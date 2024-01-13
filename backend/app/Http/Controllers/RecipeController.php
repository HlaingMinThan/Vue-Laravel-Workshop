<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RecipeController extends Controller
{
    /**
     * get all recipes and filter by category
     * GET - /api/recipes
     * @param category - optional
     */
    public function index()
    {
        try {
            return Recipe::filter(request(['category']))->paginate(6);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    /**
     * store a recipe
     * POST - /api/recipes
     * @param title,description,category_id,photo(uploaded URL - need to call upload api first)
     */
    public function store()
    {
        try {
            //validation
            $validator = Validator::make(request()->all(), [
                'title' => 'required',
                'description' => 'required',
                'category_id' => ['required', Rule::exists('categories', 'id')],
                'photo' => 'required',
            ]);

            if ($validator->fails()) {
                $flatteredErrors = collect($validator->errors())->flatMap(function ($e, $field) {
                    return [$field => $e[0]];
                });
                return response()->json([
                    'errors' => $flatteredErrors,
                    'status' => 400
                ], 400);
            }

            //if valiation pass
            $recipe = new Recipe();
            $recipe->title = request('title');
            $recipe->description = request('description');
            $recipe->photo = request('photo');
            $recipe->category_id = request('category_id');
            $recipe->save();

            return response()->json($recipe, 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }


    /**
     * update a recipe
     * POST - /api/recipes
     * @param title,description,category_id,photo(uploaded URL - need to call upload api first)
     */
    public function update($id)
    {
        try {

            $recipe = Recipe::find($id);
            if (!$recipe) {
                return response()->json([
                    'message' => 'recipe not found',
                    'status' => 404
                ], 404);
            }

            //validation
            $validator = Validator::make(request()->all(), [
                'title' => 'required',
                'description' => 'required',
                'category_id' => ['required', Rule::exists('categories', 'id')],
                'photo' => 'required',
            ]);

            if ($validator->fails()) {
                $flatteredErrors = collect($validator->errors())->flatMap(function ($e, $field) {
                    return [$field => $e[0]];
                });
                return response()->json([
                    'errors' => $flatteredErrors,
                    'status' => 400
                ], 400);
            }

            //if valiation pass
            $recipe->title = request('title');
            $recipe->description = request('description');
            $recipe->photo = request('photo');
            $recipe->category_id = request('category_id');
            $recipe->save();

            return response()->json($recipe, 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    /**
     * get single recipe
     * GET - /api/recipes/:id
     * @param category
     */
    public function show($id)
    {
        try {
            $recipe = Recipe::find($id);
            if (!$recipe) {
                return response()->json([
                    'message' => 'recipe not found',
                    'status' => 404
                ], 404);
            }
            return $recipe;
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    /**
     * delete single recipe
     * DELETE - /api/recipes/:id
     * @param id
     */
    public function destroy($id)
    {
        try {
            $recipe = Recipe::find($id);
            if (!$recipe) {
                return response()->json([
                    'message' => 'recipe not found',
                    'status' => 404
                ], 404);
            }
            $recipe->delete();
            return $recipe;
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    /**
     * upload a photo api
     * POST - /api/recipes/upload
     * @param photo
     */
    public function upload()
    {
        try {
            //validation
            $validator = Validator::make(request()->all(), [
                'photo' => ['required', 'image'],
            ]);

            if ($validator->fails()) {
                $flatteredErrors = collect($validator->errors())->flatMap(function ($e, $field) {
                    return [$field => $e[0]];
                });
                return response()->json([
                    'errors' => $flatteredErrors,
                    'status' => 400
                ], 400);
            }
            $path = '/storage/' . request('photo')->store('/recipes');
            return [
                'path' => $path,
                'status' => 200
            ];
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }
}
