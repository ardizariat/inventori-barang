<?php

namespace App\DataTables;

use App\Models\Gudang;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class GudangDataTable extends DataTable
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
                return view('admin.gudang._aksi', [
                    'query' => $query,
                    'delete' => route('gudang.destroy', $query->id),
                    'update' => route('gudang.update', $query->id),
                ]);
            })
            ->addColumn('dibuat', function ($query) {
                $dibuat = Carbon::parse($query->created_at)->format('d F Y, H:i');
                return $dibuat;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Gudang $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Gudang $model)
    {
        $model = Gudang::orderBy('created_at', 'desc');
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
            ->setTableId('gudang-table')
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
            Column::make('nama'),
            Column::make('kode'),
            Column::make('lokasi'),
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
        return 'Gudang_' . date('YmdHis');
    }
}
