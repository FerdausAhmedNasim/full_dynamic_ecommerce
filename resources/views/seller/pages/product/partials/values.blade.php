@foreach($attributes as $attribute)
    <div class="form-group row">
        <div class="col-md-3">
            <input type="text" class="form-control" value="{{ $attribute->name }}" disabled>
        </div>
        <div class="col-md-9">
            <select class="form-control select2 select2bs4 variant" name="attribute_values_{{$attribute->id}}[]"  multiple>
                @foreach($attribute->attributeValues as $value)
                    <option value="{{ $value->id }}" {{  $request->has('attribute_values_'.$attribute->id) ? (in_array($value->id , $request['attribute_values_'.$attribute->id]) ? 'selected' : '') : '' }}>{{ $value->value }}</option>
                @endforeach
            </select>
        </div>
    </div>
@endforeach
