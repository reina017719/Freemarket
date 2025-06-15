@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase-container">
    <div class="main-content">
        <div class="left-column">
            <div class="product-info">
                <div class="image-placeholder">
                    <img src="{{ asset($item->image) }}" alt="商品画像" style="width: 150px; height: auto;">
                </div>
                <div class="details">
                    <h2>{{ $item->name }}</h2>
                    <p class="price">&yen;{{ number_format($item->price) }}</p>
                </div>
            </div>
        <hr>
        <div class="section">
        <h4>支払い方法</h4>
        <form action="" method="">
            @csrf
            <select name="payment_method" id="payment-select">
                @foreach($payments as $payment)
                    <option value="{{ $payment->id }}">{{ $payment->payment_type}}</option>
                @endforeach
            </select>
            <hr>
            <div class="section">
                <h4>配送先</h4>
                <p>{{ $address->postal_code }}</p>
                <p>{{ $address->address }} {{ $address->building}}</p>
                <a href="/purchase/address/{{ $item->id }}" class="edit-link">変更する</a>
            </div>
        </div>
    </div>
        <div class="right-column">
            <div class="summary-box">
                <table>
                    <tr>
                        <td>商品代金</td>
                        <td>&yen;{{ number_format($item->price) }}</td>
                    </tr>
                    <tr>
                        <td>支払い方法</td>
                        <td id="selected-payment">{{ $payments->first()->payment_type ?? '選択してください' }}</td>
                    </tr>
                </table>
            </div>
            <button type="submit" class="purchase-button">購入する</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('payment-select');
        const display = document.getElementById('selected-payment');

        select.addEventListener('change', function () {
            const selectedText = select.options[select.selectedIndex].text;
            display.textContent = selectedText;
        });
    });
</script>
@endsection