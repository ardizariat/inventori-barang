<?php

namespace App\DataTables;

use App\Models\BarangMasuk;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BarangMasukDataTable extends DataTable
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
                return view('admin.barang_masuk._aksi', [
                    'query' => $query,
                    'delete' => route('barang-masuk.destroy', $query->id),
                    'update' => route('barang-masuk.update', $query->id),
                    'show' => route('barang-masuk.show', $query->id),
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
     * @param \App\Models\BarangMasuk $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BarangMasuk $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('barangmasuk-table')
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
                ->title('No'),
            Column::computed('product.nama_produk')
                ->sortable(true)
                ->searchable(true)
                ->title('Nama Barang'),
            Column::make('jumlah'),
            Column::make('tanggal'),
            Column::computed('aksi')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'BarangMasuk_' . date('YmdHis');
    }
}
