<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $user = User::where('id', authUser()->id)->with('wishlist.product')->first();
        return view('public.pages.wishlist.index', [
            'wishlists' => $user->wishlist()->get(),
        ]);
    }

    public function addToWishList(Request $request)
    {
        if (auth()->check()) {
            $data = $request->all();
            $filter_data = Wishlist::where("product_id", $request->product_id)->where("user_id", $request->user_id)->first();

            if (!$filter_data) {
                $wishlist = Wishlist::create($data);
                return response()->json([
                    'wishlist'   => $wishlist,
                    'message' => 'Item added to wishlist successfully'
                ]);
            }
        } else {
            return response()->json(['error' => false, 'message' => 'User not logged in.'], 401);
        }
    }

    public function wishlist()
    {
        $wishlist = Wishlist::with('product')->where('user_id', authUser()?->id)->get();

        return response()->json([
            'wishlist'   => $wishlist,
        ]);
    }
    
    public function destroy(Request $request)
    {
        if (auth()->check()) {
            $wishlist = Wishlist::where("product_id", $request->product_id)->where("user_id", $request->user_id)->first();

            if ($wishlist) {
                $wishlist->delete();
                return response()->json([
                    'message' => 'Item Deleted to wishlist successfully'
                ]);
            }
        };

        return redirect()->back();
    }
}
