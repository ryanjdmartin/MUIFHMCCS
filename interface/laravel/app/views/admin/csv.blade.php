@extends('layout')

@section('content')
<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">
      Upload/Download Fumehoods
    </h1>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
        <div class='alert alert-info'>
            <p>Here you can upload or download the CSV of fumehoods. Currently, this is the only way to populate the database with fumehood information.
            </p>
            <p>Each CSV is associated with a building. This is to avoid confusion with identical room names, etc. The actual fume hood name must be unique across all buildings, however.
            </p>
            <p>When you upload a CSV, you will first be presented with a summary screen displaying possible changes to be made. This summary screen may take a while to load depending on the number of fumehoods involved. Once the summary screen appears, you can choose what changes are to be made.
            </p>
            <p>The CSV must contain headings. These headings determine the data to be entered. If a heading is missing, it is ignored and the data is assumed to be empty. 
            <br>Headings recognized by the system are the following (must be exact):
            <table class='table table-condensed'><tr>
                <th>room</th>
                <th>name</th>
                <th>model</th>
                <th>install_date</th>
                <th>maintenance_date</th>
                <th>notes</th>
            </tr></table>
            Other headings can exist, such as building name or floor, but they will be ignored.<br>
            <b>All dates must be in the following format: YYYY-MM-DD</b>
            </p>        
            <p>Downloading the CSV will give you a compatible file, and is a good way to see how the information should be arranged.</p>        
        </div>
    </div>
    </div>
        
    <div class='row'>
      <div class='col-md-6'>
        <div class='panel panel-primary' style='text-align: center'>
          <div class='panel-heading'>
            <h4 class='panel-title'>Upload Fumehoods</h4>
          </div>
          <div class='panel-body'>
            {{Form::open(array('url' => 'admin/upload', 'class' => 'form-horizontal', 'files' => true))}}
            <div class='form-group'>
              <label class="col-sm-3 control-label">Select Building:</label>
              <div class="col-sm-9">      
                  {{Form::select('building_id', $bld_sel, '', array('class' => 'form-control'))}}
              </div>
            </div>
            <div class="form-group">
              <label class='col-sm-3 control-label'>Select CSV File: </label>
              <div class="col-sm-9">
              <div class="input-group">
                <span class="input-group-btn">
                  <span class="btn btn-primary btn-file">
                    Browse&hellip; <input type='file' name='csv'>
                  </span>
                </span>
                <input type="text" class="form-control" readonly>
                <span class="input-group-btn">
                    <button type='submit' class='btn btn-success' onClick='$(this).button("loading");' data-loading-text='Wait...'>Upload CSV</button>
                </span>
              </div>
              </div>
            </div>
            {{Form::close()}}
          </div>        
        </div>        
      </div>
      <div class='col-md-6'>
        <div class='panel panel-primary'>
          <div class='panel-heading' style='text-align:center'>
            <h4 class='panel-title'>Download Fumehoods</h4>
          </div>
          <div class='panel-body'>
            {{Form::open(array('url' => 'admin/download', 'class' => 'form-horizontal'))}}
            <div class='form-group'>
              <label class="col-sm-3 control-label">Select Building:</label>
              <div class="col-sm-9">      
                  {{Form::select('building_id', $bld_sel, '', array('class' => 'form-control'))}}
              </div>
            </div>
            <div class='form-group'>
              <div class="col-sm-offset-3 col-sm-9">      
                <button type='submit' class='btn btn-primary' href='{{route("admin.download")}}'>Download Fumehood CSV</button>
              </div>
            </div>
            {{Form::close()}}
          </div>        
        </div>        
      </div>
    </div>

</div>

    <script type='text/javascript'>
      $(document)
        .on('change', '.btn-file :file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
      });

      $(document).ready( function() {
        $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
          var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        
          if( input.length ) {
            input.val(log);
          } else {
            if( log ) alert(log);
          }
        });
    });
    </script>
@endsection
