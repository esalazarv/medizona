<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoteStoreRequest;
use App\Http\Requests\NoteUpdateRequest;
use App\Http\Resources\NoteResource;
use App\Models\Item;
use App\Models\Note;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResource
     */
    public function index(Request $request): JsonResource
    {
        $criteria = $request->get('q', '');
        $pageSize = $request->get('page_size', 15);
        $notes = Note::with('items', 'customer')->search($criteria)->paginate($pageSize);

        return NoteResource::collection($notes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NoteStoreRequest $request
     * @return JsonResponse
     */
    public function store(NoteStoreRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $selectedItems = collect($request->get('items'));
            $itemIds = $selectedItems->pluck('id');
            $items = Item::find($itemIds);
            $itemsData = $items->map(function ($item, $index) use ($selectedItems) {
                $quantity = $selectedItems->get($index)['quantity'];
                return [
                    'item_id' => $item->id,
                    'quantity' => $quantity,
                    'total' => $quantity * $item->price,
                ];
            });


            $total = $itemsData->sum('total');
            $data = $request->except('items');

            $date = Carbon::now();
            $note = Note::create([...$data, 'total' => $total, 'date' => $date]);

            $note->items()->sync($itemsData);
            DB::commit();

            $note->load('items', 'customer');
            return (new NoteResource($note))->response()->setStatusCode(Response::HTTP_CREATED);
        } catch (\Throwable $exception) {
            DB::rollBack();
            return abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'Something went wrong creating the note');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Note $note
     * @return NoteResource
     */
    public function show(Note $note): NoteResource
    {
        $note->load('items', 'customer');
        return new NoteResource($note);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NoteUpdateRequest $request
     * @param \App\Models\Note $note
     * @return NoteResource
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function update(NoteUpdateRequest $request, Note $note)
    {
        try {
            DB::beginTransaction();
            $selectedItems = collect($request->get('items'));
            $itemIds = $selectedItems->pluck('id');
            $items = Item::find($itemIds);

            $itemsData = $items->map(function ($item, $index) use ($selectedItems) {
                $quantity = $selectedItems->get($index)['quantity'];
                return [
                    'item_id' => $item->id,
                    'quantity' => $quantity,
                    'total' => $quantity * $item->price,
                ];
            });

            $total = $itemsData->sum('total');
            $data = $request->except('items');

            $date = Carbon::now();
            $note->update([...$data, 'total' => $total, 'date' => $date]);
            $note->items()->sync($itemsData);

            DB::commit();

            $note->load('items', 'customer');
            return new NoteResource($note);
        } catch (\Throwable $exception) {
            DB::rollBack();
            return abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'Something went wrong creating the note');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $note->delete();
        return \response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
