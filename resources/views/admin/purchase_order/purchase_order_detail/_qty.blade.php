<form>
    <input type="number" data-id="{{ $data->id }}" data-total_harga="{{ $total_harga }}"
        data-total_item="{{ $total_item }}" name="qty_{{ $data->id }}" class="qty form-control input-sm"
        value="{{ $data->qty }}">
</form>
