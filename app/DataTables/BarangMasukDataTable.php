<?php

namespace App\DataTables;

use App\Models\BarangMasuk;
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
            ->eloquent($query);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\BarangMasuk $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BarangMasuk $model)
    {
        $model = BarangMasuk::with(['produk'])->orderBy('created_at', 'desc');
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
            Column::computed('produk.nama_produk')
                ->sortable(true)
                ->searchable(true)
                ->title('Nama Produk'),
            Column::make('jumlah'),
            Column::make('satuan'),
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
