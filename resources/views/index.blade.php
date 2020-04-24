<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">代码生成器</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        <form method="post" action="{{$action}}" id="scaffold" pjax-container>

            <div class="box-body">

                <div class="form-horizontal">

                <div class="form-group">

                    <label for="inputTableName" class="col-sm-1 control-label">数据表名</label>

                    <div class="col-sm-4">
                        <input type="text" name="table_name" class="form-control" id="inputTableName" placeholder="table name" value="{{ old('table_name') }}">
                    </div>

                    <span class="help-block hide" id="table-name-help">
                        <i class="fa fa-info"></i>&nbsp; 数据表名不能为空！
                    </span>

                </div>
                <div class="form-group">
                    <label for="inputModelName" class="col-sm-1 control-label">模型名称</label>

                    <div class="col-sm-4">
                        <input type="text" name="model_name" class="form-control" id="inputModelName" placeholder="model" value="{{ old('model_name', "App\\Models\\") }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputControllerName" class="col-sm-1 control-label">控制名称</label>

                    <div class="col-sm-4">
                        <input type="text" name="controller_name" class="form-control" id="inputControllerName" placeholder="controller" value="{{ old('controller_name', "App\\Admin\\Controllers\\") }}">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-11">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" checked value="migration" name="create[]" /> 创建迁移
                            </label>
                            <label>
                                <input type="checkbox" checked value="model" name="create[]" /> 创建模型
                            </label>
                            <label>
                                <input type="checkbox" checked value="lang" name="create[]" /> 创建翻译
                            </label>
                            <label>
                                <input type="checkbox" checked value="controller" name="create[]" /> 创建控制器
                            </label>
                            <label>
                                <input type="checkbox" checked value="migrate" name="create[]" /> 运行迁移
                            </label>
                        </div>
                    </div>
                </div>

                </div>

                <hr />

                <h4>Fields</h4>

                <table class="table table-hover" id="table-fields">
                    <tbody>
                    <tr>
                        <th style="width: 200px">字段名</th>
                        <th>翻译</th>
                        <th>类型</th>
                        <th>表单</th>
                        <th>允许空值</th>
                        <th>索引</th>
                        <th>默认值</th>
                        <th>注释</th>
                        <th>操作</th>
                    </tr>

                    @if(old('fields'))
                        @foreach(old('fields') as $index => $field)
                            <tr>
                                <td>
                                    <input type="text" name="fields[{{$index}}][name]" class="form-control" placeholder="field name" value="{{$field['name']}}" />
                                </td>
                                <td>
                                    <input type="text" name="fields[{{$index}}][translation]" class="form-control" placeholder="{{trans('admin.scaffold.translation')}}" value="{{$field['translation']}}" />
                                </td>
                                <td>
                                    <select style="width: 200px" name="fields[{{$index}}][type]">
                                        @foreach($dbTypes as $type)
                                            <option value="{{ $type }}" {{$field['type'] == $type ? 'selected' : '' }}>{{$type}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select style="width: 200px" name="fields[{{$index}}][form]">
                                        @foreach($form as $v)
                                            <option value="{{ $v }}" {{$field['form'] == $v ? 'selected' : '' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="checkbox" name="fields[{{$index}}][nullable]" {{ \Illuminate\Support\Arr::get($field, 'nullable') == 'on' ? 'checked': '' }}/></td>
                                <td>
                                    <select style="width: 150px" name="fields[{{$index}}][key]">
                                        {{--<option value="primary">Primary</option>--}}
                                        <option value="" {{$field['key'] == '' ? 'selected' : '' }}>NULL</option>
                                        <option value="unique" {{$field['key'] == 'unique' ? 'selected' : '' }}>Unique</option>
                                        <option value="index" {{$field['key'] == 'index' ? 'selected' : '' }}>Index</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" placeholder="default value" name="fields[{{$index}}][default]" value="{{$field['default']}}"/></td>
                                <td><input type="text" class="form-control" placeholder="comment" name="fields[{{$index}}][comment]" value="{{$field['comment']}}" /></td>
                                <td><a class="btn btn-sm btn-danger table-field-remove"><i class="fa fa-trash"></i> remove</a></td>
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td>
                            <input type="text" name="fields[0][name]" class="form-control" placeholder="field name" />
                        </td>
                        <td>
                            <input type="text" name="fields[0][translation]" class="form-control" placeholder="translation" />
                        </td>
                        <td>
                            <select style="width: 200px" name="fields[0][type]">
                                @foreach($dbTypes as $type)
                                    <option value="{{ $type }}">{{$type}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select style="width: 200px" name="fields[0][form]">
                                @foreach($form as $v)
                                    <option value="{{ $v }}">{{ $v }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="checkbox" name="fields[0][nullable]" /></td>
                        <td>
                            <select style="width: 150px" name="fields[0][key]">
                                {{--<option value="primary">Primary</option>--}}
                                <option value="" selected>NULL</option>
                                <option value="unique">Unique</option>
                                <option value="index">Index</option>
                            </select>
                        </td>
                        <td><input type="text" class="form-control" placeholder="default value" name="fields[0][default]"></td>
                        <td><input type="text" class="form-control" placeholder="comment" name="fields[0][comment]"></td>
                        <td><a class="btn btn-sm btn-danger table-field-remove"><i class="fa fa-trash"></i> 删除</a></td>
                    </tr>
                    @endif
                    </tbody>
                </table>

                <hr style="margin-top: 0;"/>

                <div class='form-inline margin' style="width: 100%">


                    <div class='form-group'>
                        <button type="button" class="btn btn-sm btn-success" id="add-table-field"><i class="fa fa-plus"></i>&nbsp;&nbsp;添加字段</button>
                    </div>

                    <div class='form-group pull-right' style="margin-right: 20px; margin-top: 5px;">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" checked name="timestamps"> 创建时间 & 更新时间
                            </label>
                            &nbsp;&nbsp;
                            <label>
                                <input type="checkbox" name="soft_deletes"> 逻辑删除
                            </label>

                        </div>
                    </div>

                    <div class="form-group pull-right" style="margin-right: 20px;">
                        <label for="inputPrimaryKey">主键</label>
                        <input type="text" name="primary_key" class="form-control" id="inputPrimaryKey" placeholder="Primary key" value="id" style="width: 100px;">
                    </div>

                </div>

                {{--<hr />--}}

                {{--<h4>Relations</h4>--}}

                {{--<table class="table table-hover" id="model-relations">--}}
                    {{--<tbody>--}}
                    {{--<tr>--}}
                        {{--<th style="width: 200px">Relation name</th>--}}
                        {{--<th>Type</th>--}}
                        {{--<th>Related model</th>--}}
                        {{--<th>forignKey</th>--}}
                        {{--<th>OtherKey</th>--}}
                        {{--<th>With Pivot</th>--}}
                        {{--<th>Action</th>--}}
                    {{--</tr>--}}
                    {{--</tbody>--}}
                {{--</table>--}}

                {{--<hr style="margin-top: 0;"/>--}}

                {{--<div class='form-inline margin' style="width: 100%">--}}

                    {{--<div class='form-group'>--}}
                        {{--<button type="button" class="btn btn-sm btn-success" id="add-model-relation"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add relation</button>--}}
                    {{--</div>--}}

                {{--</div>--}}

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">submit</button>
            </div>

            {{ csrf_field() }}

            <!-- /.box-footer -->
        </form>

    </div>

</div>

<template id="table-field-tpl">
    <tr>
        <td>
            <input type="text" name="fields[__index__][name]" class="form-control" placeholder="field name" />
        </td>
        <td>
            <input type="text" name="fields[__index__][translation]" class="form-control" placeholder="translation" />
        </td>
        <td>
            <select style="width: 200px" name="fields[__index__][type]">
                @foreach($dbTypes as $type)
                    <option value="{{ $type }}">{{$type}}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select style="width: 200px" name="fields[__index__][form]">
                @foreach($form as $v)
                    <option value="{{ $v }}">{{$v}}</option>
                @endforeach
            </select>
        </td>
        <td><input type="checkbox" name="fields[__index__][nullable]" /></td>
        <td>
            <select style="width: 150px" name="fields[__index__][key]">
                <option value="" selected>NULL</option>
                <option value="unique">Unique</option>
                <option value="index">Index</option>
            </select>
        </td>
        <td><input type="text" class="form-control" placeholder="default value" name="fields[__index__][default]"></td>
        <td><input type="text" class="form-control" placeholder="comment" name="fields[__index__][comment]"></td>
        <td><a class="btn btn-sm btn-danger table-field-remove"><i class="fa fa-trash"></i> 删除</a></td>
    </tr>
</template>

<template id="model-relation-tpl">
    <tr>
        <td><input type="text" class="form-control" placeholder="relation name" value=""></td>
        <td>
            <select style="width: 150px">
                <option value="HasOne" selected>HasOne</option>
                <option value="BelongsTo">BelongsTo</option>
                <option value="HasMany">HasMany</option>
                <option value="BelongsToMany">BelongsToMany</option>
            </select>
        </td>
        <td><input type="text" class="form-control" placeholder="related model"></td>
        <td><input type="text" class="form-control" placeholder="default value"></td>
        <td><input type="text" class="form-control" placeholder="default value"></td>
        <td><input type="checkbox" /></td>
        <td><a class="btn btn-sm btn-danger model-relation-remove"><i class="fa fa-trash"></i> remove</a></td>
    </tr>
</template>

<script>

$(function () {

    $('input[type=checkbox]').iCheck({checkboxClass:'icheckbox_minimal-blue'});
    $('select').select2();

    $('#add-table-field').click(function (event) {
        $('#table-fields tbody').append($('#table-field-tpl').html().replace(/__index__/g, $('#table-fields tr').length - 1));
        $('select').select2();
        $('input[type=checkbox]').iCheck({checkboxClass:'icheckbox_minimal-blue'});
    });

    $('#table-fields').on('click', '.table-field-remove', function(event) {
        $(event.target).closest('tr').remove();
    });

    $('#add-model-relation').click(function (event) {
        $('#model-relations tbody').append($('#model-relation-tpl').html().replace(/__index__/g, $('#model-relations tr').length - 1));
        $('select').select2();
        $('input[type=checkbox]').iCheck({checkboxClass:'icheckbox_minimal-blue'});

        relation_count++;
    });

    $('#model-relations').on('click', '.model-relation-remove', function(event) {
        $(event.target).closest('tr').remove();
    });

    $('#scaffold').on('submit', function (event) {

        //event.preventDefault();

        if ($('#inputTableName').val() == '') {
            $('#inputTableName').closest('.form-group').addClass('has-error');
            $('#table-name-help').removeClass('hide');

            return false;
        }

        return true;
    });
});

</script>