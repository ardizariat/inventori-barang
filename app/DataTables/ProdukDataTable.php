<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\Produk;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProdukDataTable extends DataTable
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
                return view('admin.produk._aksi', [
                    'query' => $query,
                    'delete' => route('produk.destroy', $query->id),
                    'update' => route('produk.update', $query->id),
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Produk $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Produk $model)
    {
        $model = Produk::with(['kategori', 'gudang'])->orderBy('created_at', 'desc');
        // return $model->newQuery();

        $kategori = $this->request()->get('kategori');
        $gudang = $this->request()->get('gudang');
        $query = $model->newQuery();
        if ($kategori) {
            $query = $query->where('kategori_id', $kategori);
        }
        if ($gudang) {
            $query = $query->where('gudang_id', $gudang);
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
            ->setTableId('produk-table')
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
            Column::make('nama_produk'),
            Column::computed('kategori.kategori')
                ->sortable(true)
                ->searchable(true)
                ->title('Kategori'),
            Column::computed('gudang.nama')
                ->sortable(true)
                ->searchable(true)
                ->title('Gudang'),
            Column::make('stok'),
            Column::make('minimal_stok'),
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
        return 'Produk_' . date('YmdHis');
    }
}
