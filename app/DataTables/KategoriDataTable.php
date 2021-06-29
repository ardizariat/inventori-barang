<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\Kategori;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KategoriDataTable extends DataTable
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
                return view('admin.kategori._aksi', [
                    'edit' => route('kategori.update', $query->id),
                    'delete' => route('kategori.destroy', $query->id),
                    'query' => $query
                ]);
            })
            // ->addColumn('#', function ($query) {
            //     return view('admin.kategori._checkbox', [
            //         'query' => $query
            //     ]);
            // })
            ->addColumn('dibuat', function ($query) {
                $query = Carbon::parse($query->created_at)->format('d F Y, H:i');
                return $query;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Kategori $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Kategori $model)
    {
        $model = Kategori::orderBy('created_at', 'desc');
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
            ->setTableId('kategori-table')
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
            Column::make('kategori'),
            Column::make('status'),
            Column::make('dibuat'),
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
        return 'Kategori_' . date('YmdHis');
    }
}
