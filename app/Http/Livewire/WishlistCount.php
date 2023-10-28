<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistCount extends Component
{
    public $wishlistcount;

    protected $listeners = ['WishlistAddedUpdated' => 'WishlistCartCount'];

    public function CheckWishlistCount() {
        
        if(Auth::check()) {
            return $this->wishlistcount = Wishlist::where('user_id', auth()->user()->id)->count();
        } else {
            return $this->wishlistcount = 0;
        }
    }

    public function render()
    {
        $this->wishlistcount = $this->CheckWishlistCount();
        return view('livewire.wishlist-count', [
            'wishlistcount' => $this->wishlistcount
        ]);
    }
}
