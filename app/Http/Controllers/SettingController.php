<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\FoodDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('roles')->get();
        $categories = Category::orderBy('name')->get();

        if ($request->search) {
            $foods = FoodDetail::with('category')
                ->when($request->search ?? null, function ($query, $search) {
                    return $query->where('name', 'like', '%' . $search . '%');
                })
                ->when($request->filters['category'] ?? null, function ($query, $category) {
                    return $query->where('category_id', $category);
                })
                ->orderBy('name')->get();
        } else {
            $foods = FoodDetail::with('category')->orderBy('name')->get();
        }

        return inertia('Settings', [
            'foods' => $foods,
            'users' => $users,
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        $temp_files = TemporaryFile::where('user_id', Auth::id())->get();
        foreach ($temp_files as $temp_file) {
            $filename = $temp_file->filename;
            $temp_file->delete();

            if (file_exists(storage_path('app/public/temp-upload/' . $filename))) {
                unlink(storage_path('app/public/temp-upload/' . $filename));
            }
        }

        return inertia('Food/NewFood', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $temporaryFile = TemporaryFile::where('user_id', Auth::user()->id)->first();

        if ($temporaryFile) {
            $file = $temporaryFile->filename;
            $name = Str::slug($request['name'], '-');
            $filename = $name . '-' . $file;
            Storage::move('public/temp-upload/' . $temporaryFile->filename, 'public/images/foods/' . $filename);
        }

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'unit' => 'required',
        ]);

        $food = FoodDetail::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'unit' => $request->unit,
            'photo' => $filename ?? null,
            'is_available' => $request->is_available ?? false,
            'is_recommended' => $request->is_recommended ?? false,
            'is_favorite' => $request->is_favorite ?? false,
        ]);

        return redirect()->route('settings')->with([
            'flash' => [
                'title' => '<strong>Success!</strong>',
                'html' =>  '<b>' . $request->name . '</b> successfully created!',
                'type' => 'success',
            ],
        ]);
    }

    public function show(Request $request)
    {
        $food = FoodDetail::find($request->id);
        $categories = Category::orderBy('name')->get();

        return inertia('Food/EditFood', [
            'food' => $food,
            'categories' => $categories,
        ]);
    }


    public function recommended(Request $request)
    {
        $food = FoodDetail::find($request['id']);
        $food->is_recommended = $request['is_recommended'];
        $food->save();

        if ($request['is_recommended'] == true) {
            return redirect()->route('settings')->with([
                'flash' => [
                    'title' => '<strong>Success!</strong>',
                    'html' => "Food has been added to <br><b>Chef-Recommended</b>",
                    'type' => "success",
                    'toast' => true,
                ],
            ]);
        } else {
            return redirect()->route('settings')->with([
                'flash' => [
                    'title' => '<strong>Success!</strong>',
                    'html' => "Food has been removed from <br><b>Chef-Recommended</b>",
                    'type' => "success",
                    'toast' => true,
                ]
            ]);
        }
    }

    public function favourite(Request $request)
    {
        $food = FoodDetail::find($request['id']);
        $food->is_favorite = $request['is_favorite'];
        $food->save();

        if ($request['is_favorite'] == true) {
            return redirect()->route('settings')->with([
                'flash' => [
                    'title' => '<strong>Success!</strong>',
                    'html' => "Food has been added to<br><b>Favourite</b>",
                    'type' => 'success',
                    'toast' => true,
                ],
            ]);
        } else {
            return redirect()->route('settings')->with([
                'flash' => [
                    'title' => '<strong>Success!</strong>',
                    'html' => "Food has been removed from<br><b>Favourite</b>",
                    'type' => 'success',
                    'toast' => true,
                ],
            ]);
        }
    }

    public function status(Request $request)
    {
        $food = FoodDetail::find($request['id']);
        $food->is_available = $request['is_available'];
        $food->save();

        if ($request['is_available'] == true) {
            return redirect()->route('settings')->with([
                'flash' => [
                    'title' => '<strong>Success!</strong>',
                    'html' => "Food has been added to<br><b>Available</b>",
                    'type' => 'success',
                    'toast' => true,
                ],
            ]);
        } else {
            return redirect()->route('settings')->with([
                'flash' => [
                    'title' => '<strong>Success!</strong>',
                    'html' => "Food has been removed from<br><b>Available</b>",
                    'type' => 'success',
                    'toast' => true,
                ],
            ]);
        }
    }

    public function category(Request $request)
    {
        $food = FoodDetail::find($request['id']);
        $food->category_id = $request['category_id'];
        $food->save();

        return redirect()->route('settings')->with([
            'flash' => [
                'title' => '<strong>Success!</strong>',
                'html' => "Food has been moved to<br><b>" . $food->category->name . "</b>",
                'type' => 'success',
                'toast' => true,
            ],
        ]);
    }

    public function food_update(Request $request)
    {
        $temporaryFile = TemporaryFile::where('user_id', Auth::user()->id)->first();

        if ($temporaryFile) {
            $file = $temporaryFile->filename;
            $name = Str::slug($request->name, '-');
            $filename = $name . '-' . $file;
            Storage::move('public/temp-upload/' . $temporaryFile->filename, 'public/images/foods/' . $filename);
        }

        $food = FoodDetail::find($request->id);
        $food->name = $request->name;
        $food->description = $request->description;
        $food->price = $request->price;
        $food->photo = $filename ?? $food->photo;
        $food->unit = $request->unit;
        $food->save();

        if ($temporaryFile) {
            $temporaryFile->delete();
        }

        return redirect()->route('settings')->with([
            'flash' => [
                'title' => '<strong>Success!</strong>',
                'text' => 'Food updated successfully',
                'type' => 'success',
                'toast' => true,
            ],
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->hasFile('photo')) {
            $checkFile = TemporaryFile::where('user_id', Auth::user()->id)->get();
            if ($checkFile->count() > 0) {
                unlink(storage_path('app/public/temp-upload/' . $checkFile[0]->filename));
                $checkFile->each->delete();
            }

            $file = $request->file('photo');
            $ext = $file->getClientOriginalExtension();
            $filename = date('dmY-His') . '.' . $ext;
            $file->storeAs('public/temp-upload', $filename);

            TemporaryFile::create([
                'filename' => $filename,
                'user_id' => Auth::user()->id,
            ]);
        }
    }

    public function deleteUpload(Request $request)
    {
        $file = TemporaryFile::where('user_id', '=', Auth::user()->id)->latest();
        $filename = $file->first()->filename;
        $file->delete();

        if (file_exists(storage_path('app/public/temp-upload/' . $filename))) {
            unlink(storage_path('app/public/temp-upload/' . $filename));
        }
    }

    public function destroy(Request $request)
    {
        $food = FoodDetail::find($request['id']);
        $name = $food->name;
        $food->delete();

        return redirect()->route('settings')->with([
            'flash' => [
                'title' => '<strong>Success!</strong>',
                'html' => '<b>' . $name . '</b> has been deleted successfully',
                'type' => 'success',
            ],
        ]);
    }
}
