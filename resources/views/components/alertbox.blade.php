@if(Session::has('msg'))
	<div class="card-block" style="margin-bottom: 15px;">
	    <div class="col-lg-12">
	        <div class="alert alert-{{ key(Session::get('msg')) }} alert-dismissable mb-0 mt-0">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	            @foreach (Session::get('msg')[key(Session::get('msg'))] as $msg)
	                <p class="mb-1">{!! $msg !!}</p>
	            @endforeach
	            @foreach ($errors->all('<p>:message</p>') as $error)
	                {!! $error !!}
	            @endforeach
	        </div>
	    </div>
	</div>
@endif