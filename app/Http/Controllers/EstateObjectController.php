<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\EstateObject;
use Illuminate\Support\Facades\Storage;

class EstateObjectController extends Controller
{
    public function get_estateObjects() {
         $estateObjects = EstateObject::all();
         return Inertia::render('EstateObjects', [
            'title' => 'Объекты',
            'estateObjects' => $estateObjects,
        ]);
    }

    public function get_estate(Request $request, $id) {
         $object = EstateObject::findOrFail($id);
         
        return Inertia::render('ObjectDetail', [
            'title' => 'Просмотр объекта',
            'estateObject' => $object,
            'fromDate' => $request->query('from'),
            'toDate' => $request->query('to'),
            'guests' => $request->query('guests'),
        ]);

    }

    public function get_form()
    {
        return Inertia::render('CreateObject', [
            'title' => 'СоздатьОбъект'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = EstateObject::storeImage($request->file('image'));
        }
        EstateObject::create($data);

        return back();
    }

    public function destroy($id)
    {
        $object = EstateObject::findOrFail($id);

        if ($object->image) {
            Storage::disk('public')->delete($object->image);
        }

        $object->delete();

        return redirect('/objects');
    }

    public function edit($id)
    {
        $estateObject = EstateObject::findOrFail($id);

        return Inertia::render('UpdateObject', [
            'title' => 'Редактирование объекта',
            'estateObject' => $estateObject,
        ]);
    }

public function update(Request $request, $id)
{   
    $data = $request->all();
    $estateObject = EstateObject::findOrFail($id);
      if ($request->hasFile('image')) {
            $data['image'] = EstateObject::storeImage($request->file('image'));
        }
    $estateObject->update($data);
    return redirect('/objects');
}


}
