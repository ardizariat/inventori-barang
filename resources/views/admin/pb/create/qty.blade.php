<form>
    <input type="number" data-produk="{{ $data->product->stok }}" data-total_item="{{ $total_item }}"
        data-id="{{ $data->id }}" name="qty_{{ $data->id }}" class="qty form-control input-sm"
        value="{{ $data->qty }}">
</form>
