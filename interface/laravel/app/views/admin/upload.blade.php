@extends('layout')

@section('content')
<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">
      Uploading Fumehood CSV: {{$building->name}} ({{$building->abbv}})
    </h1>
    <div class='alert alert-info'>
        <p>Select which data to update in the database. Each section can be saved independently, or ignored altogether. Press "Done" at the bottom when finished.
        <p><b>Note: Fumehoods with unknown rooms will have rooms automatically created.</b><p>
        <ul>
          <li>Add New Fumehoods: Fumehoods within the uploaded file that do not appear in the database will be added to the database. If unchecked, new fumehoods will be ignored.</li>
          <li>Update Existing Fumehoods: Data within the uploaded file will overwrite existing hoods in the database. If unchecked, existing fumehoods will not be altered even if they appear in the CSV.</li>
        </ul>
    </div>
  </div>
</div>
    
<div class="row">
    <div class="col-md-12">
        <div class='panel panel-info'>
          <div class='panel-heading'>
            <h4 class='panel-title'>Add Fumehoods in {{$building->abbv}}</h4>
          </div>
        <table class='table table-condensed table-striped table-hover manager-table' id='building-table'>
            <thead>
                <tr>
                    <th class='col-xs-2'>
                        Room
                    </th>
                    <th class='col-xs-2'>
                        Name
                    </th>
                    <th class='col-xs-2'>
                        Model
                    </th>
                    <th class='col-xs-1'>
                        Install Date
                    </th>
                    <th class='col-xs-2'>
                        Maintenance Date
                    </th>
                    <th class='col-xs-2'>
                        Notes
                    </th>
                    <th class='col-xs-1'>
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
            @foreach ($add as $f)
                <tr>
                    <td class='col-xs-2'>
                        {{$building->abbv}} {{$f['room']}} 
                        @if ($f['room_id'] == 0)
                            <span class='badge'>NEW</span>
                        @endif
                    </td>
                    <td class='col-xs-2'>
                        {{$f['name']}}
                    </td>
                    <td class='col-xs-2'>
                        {{$f['model']}}
                    </td>
                    <td class='col-xs-1'>
                        {{$f['install_date']}}
                    </td>
                    <td class='col-xs-2'>
                        {{$f['maintenance_date']}}
                    </td>
                    <td class='col-xs-2'>
                        {{$f['notes']}}
                    </td>
                    <td class='col-xs-1'>
                        <button type='submit' class='btn btn-info btn-xs'>Add</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
      </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class='panel panel-success'>
          <div class='panel-heading'>
            <h4 class='panel-title'>Update Fumehoods in {{$building->abbv}}</h4>
          </div>
        <table class='table table-condensed table-striped table-hover manager-table' id='building-table'>
            <thead>
                <tr>
                    <th class='col-xs-2'>
                        Room
                    </th>
                    <th class='col-xs-2'>
                        Name
                    </th>
                    <th class='col-xs-2'>
                        Model
                    </th>
                    <th class='col-xs-1'>
                        Install Date
                    </th>
                    <th class='col-xs-2'>
                        Maintenance Date
                    </th>
                    <th class='col-xs-2'>
                        Notes
                    </th>
                    <th class='col-xs-1'>
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
            @foreach ($update as $f)
                <tr>
                    <td class='col-xs-2'>
                        {{$building->abbv}} {{$f['room']}} 
                        @if (!$f['room_id'])
                            <span class='badge'>NEW</span>
                        @endif
                    </td>
                    <td class='col-xs-2'>
                        {{$f['name']}}
                    </td>
                    <td class='col-xs-2'>
                        {{$f['model']}}
                    </td>
                    <td class='col-xs-1'>
                        {{$f['install_date']}}
                    </td>
                    <td class='col-xs-2'>
                        {{$f['maintenance_date']}}
                    </td>
                    <td class='col-xs-2'>
                        {{$f['notes']}}
                    </td>
                    <td class='col-xs-1'>
                        <button type='submit' class='btn btn-success btn-xs'>Update</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
      </div>
    </div>
</div>

<div class='row'>
    <div class='col-md-12'>
        <div class='pull-right'>
            <a class='btn btn-primary' href='{{route("admin.hoods")}}'>Done</a>
            <br><br>
        </div>
    </div>
</div>
@endsection
