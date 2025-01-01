<form method="POST" action="{{route('store.idol.name')}}">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <input type="text" name="idol_name" id="" class="form-control" placeholder="Enter idol name"
                    value="{{ optional($idolImage)->idol_name }}" required>
            </div>
        </div>
        <div class="form-group col-12 d-flex justify-content-end col-form-label">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary ml-1" data-dismiss="modal">Close</button>
        </div>
    </div>
</form>
