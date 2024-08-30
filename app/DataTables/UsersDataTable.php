<?php
namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
  public function dataTable(QueryBuilder $query): EloquentDataTable
  {
    return (new EloquentDataTable($query))
      ->setRowId('id')
      ->editColumn('fullname', function (User $user) {
        return $user->name;
      })
      ->filterColumn('fullname', function ($query, $keyword) {
        $sql = "CONCAT(users.firstname,' ',users.lastname) like ?";
        $query->whereRaw($sql, ["%$keyword%"]);
      })
      ->orderColumn('fullname', "CONCAT(users.firstname,' ',users.lastname)");
  }

  public function query(User $model): QueryBuilder
  {
    return $model->newQuery();
  }

  public function html(): HtmlBuilder
  {
    return $this->builder()
      ->setTableId('users-table')
      ->columns($this->getColumns())
      ->minifiedAjax()
      ->orderBy(0, 'asc')
      ->selectStyleSingle()
      ->buttons([
        Button::make('excel'),
        Button::make('csv'),
        Button::make('pdf'),
        Button::make('print'),
        Button::make('reset'),
        Button::make('reload'),
      ]);
  }

  public function getColumns(): array
  {
    return [
      Column::make('id'),
      Column::computed('fullname')->searchable(true)->orderable(true),
      Column::make('email'),
      Column::make('created_at'),
      Column::make('updated_at')
    ];
  }

  protected function filename(): string
  {
    return 'Users_' . date('YmdHis');
  }
}