<div class="modal fade bd-example-modal-lg modal-form animate__animated animate__pulse" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form>
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table supplier-table table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>No PB</th>
                                <th>Pemohon</th>
                                <th>Tanggal</th>
                                <th width="15%" align="center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pb as $item)
                                <tr>
                                    <td width="5%">{{ $loop->iteration }}</td>
                                    <td>{{ $item->no_dokumen }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td width="15%" align="center">
                                        <button @if ($item->sect_head != 'approved' || $item->dept_head != 'approved') disabled @endif
                                            onclick="pilihPB(`{{ route('barang-keluar.store', $item->id) }}`,`{{ $item->id }}`)"
                                            class="btn btn-xs btn-primary">
                                            <i class="fas fa-check-circle"></i> Pilih
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
