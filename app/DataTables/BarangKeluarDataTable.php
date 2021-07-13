<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\BarangKeluar;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BarangKeluarDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('aksi', function ($query) {
                return view('admin.barang_keluar._aksi', [
                    'query' => $query,
                    'delete' => route('barang-keluar.destroy', $query->id),
                    'update' => route('barang-keluar.update', $query->id),
                    'show' => route('barang-keluar.show', $query->id),
                ]);
            })
            ->addColumn('jumlah', function ($query) {
                $jumlah = $query->jumlah;
                $satuan = $query->satuan;
                $total = $jumlah . ' ' . $satuan;
                return $total;
            })
            ->addColumn('tanggal', function ($query) {
                $tanggal = Carbon::parse($query->tanggal)->format('d F Y');
                return $tanggal;
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\BarangKeluar $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BarangKeluar $model)
    {
        $start = $this->request()->get('awal');
        $end = $this->request()->get('akhir');

        $model = BarangKeluar::orderBy('created_at', 'desc');
        $query = $model->newQuery();

        if (!empty($start) && !empty($end)) {
            $start = Carbon::parse($start);
            $end = Carbon::parse($end);

            $query = $query->whereBetween('tanggal', [$start, $end]);
        }

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('barangkeluar-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')
                ->title('No')
                ->sortable(false)
                ->searchable(false),
            Column::computed('product.nama_produk')
                ->sortable(true)
                ->searchable(true)
                ->title('Nama Barang'),
            Column::computed('product.category.kategori')
                ->sortable(true)
                ->searchable(true)
                ->title('Kategori'),
            Column::make('jumlah'),
            Column::make('tanggal')
                ->searchable(true),
            Column::computed('aksi')
                ->exportable(false)
                ->printable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'BarangKeluar_' . date('YmdHis');
    }
}
