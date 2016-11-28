<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $member->id !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $member->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $member->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $member->deleted_at !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $member->name !!}</p>
</div>

<!-- Primary Role Field -->
<div class="form-group">
    {!! Form::label('primary_role', 'Primary Role:') !!}
    <p>{!! $member->primary_role !!}</p>
</div>

<!-- Biography Field -->
<div class="form-group">
    {!! Form::label('biography', 'Biography:') !!}
    <p>{!! $member->biography !!}</p>
</div>

