@extends('layout')

@section('content')
<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">
      Uploading Fumehood CSV
    </h1>
    <div class='alert alert-info'>
        <p>Select which data to update in the database. Each section can be saved independently, or ignored altogether. Press "Done" at the bottom when finished.
        <ul>
          <li>Create Rooms: Fumehoods with unknown rooms can have entries automatically created.</li>
          <li>Update Existing Fumehoods: Data within the uploaded file will overwrite existing hoods in the database. If unchecked, existing fumehoods will not be altered even if they appear in the CSV.</li>
          <li>Add New Fumehoods: Fumehoods within the uploaded file that do not appear in the database will be added to the database. If unchecked, new fumehoods will be ignored.</li>
          <li>Remove Missing Fumehoods: Fumehoods in the database which do not appear in the uploaded file will be deleted. This change is irreversible. All measurement data associated with the fumehood will be deleted.</li>
        </ul>
    </div>
    <p>Do something here</p>
    <div class='row'>
        <div class='col-md-12'>
            <div class='pull-right'>
                <a class='btn btn-primary' href='{{route("admin.hoods")}}'>Done</a>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection
