<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Cart;
use App\Models\CartDetail;
use Illuminate\Support\Facades\Auth;

class CartCount extends Component
{
    public $cartcount;

    protected $listeners = ['CartAddedUpdated' => 'CheckCartCount'];

    public function CheckCartCount() {
        
        if (Auth::check()) {
            $cart = Cart::where('user_id', auth()->user()->id)
                        ->where('status_cart', 'cart')
                        ->first();
            if ($cart) {
                return $this->cartcount = CartDetail::where('cart_id', $cart->id)->count();
            } else {
                return $this->cartcount = 0;
            }
        } else {
            return $this->cartcount = 0;
        }
    }

    public function render()
    {
        $this->cartcount = $this->CheckCartCount();
        return view('livewire.cart-count', [
            'cartcount' => $this->cartcount
        ]);
    }
}
