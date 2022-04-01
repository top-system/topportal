@if(isset($options->relationship))

    {{-- If this is a relationship and the method does not exist, show a warning message --}}
    @if( !method_exists( $dataType->model_name, \Illuminate\Support\Str::camel($row->field) ) )
        <p class="label label-warning"><i class="admin-warning"></i> {{ __('admin::form.field_select_dd_relationship', ['method' => \Illuminate\Support\Str::camel($row->field).'()', 'class' => $dataType->model_name]) }}</p>
    @endif

    @if( method_exists( $dataType->model_name, \Illuminate\Support\Str::camel($row->field) ) )
        @if(isset($dataTypeContent->{$row->field}) && !is_null(old($row->field, $dataTypeContent->{$row->field})))
            <?php $selected_value = old($row->field, $dataTypeContent->{$row->field}); ?>
        @else
            <?php $selected_value = old($row->field); ?>
        @endif

        <?php $default = (isset($options->default) && !isset($dataTypeContent->{$row->field})) ? $options->default : null; ?>

        {{-- Populate all options from relationship --}}
        <?php
        $relationshipListMethod = \Illuminate\Support\Str::camel($row->field) . 'List';
        if (method_exists($dataTypeContent, $relationshipListMethod)) {
            $relationshipOptions = $dataTypeContent->$relationshipListMethod();
        } else {
            $relationshipClass = $dataTypeContent->{\Illuminate\Support\Str::camel($row->field)}()->getRelated();
            if (isset($options->relationship->where)) {
                $relationshipOptions = $relationshipClass::where(
                    $options->relationship->where[0],
                    $options->relationship->where[1]
                )->get();
            } else {
                $relationshipOptions = $relationshipClass::all();
            }
        }

        // Try to get default value for the relationship
        // when default is a callable function (ClassName@methodName)
        if ($default != null) {
            $comps = explode('@', $default);
            if (count($comps) == 2 && method_exists($comps[0], $comps[1])) {
                $default = call_user_func([$comps[0], $comps[1]]);
            }
        }

        ?>
        <div id="treeview-{{ $row->field }}" class=""></div>
        <script>
            window.onload=function(){
                $('#treeview-{{ $row->field }}').treeview({
                    data: {!! json_encode(makeTreeViewJson($relationshipOptions->toArray())) !!},
                    onNodeSelected: function(event, node) {
                        console.log(node);
                    },
                    onNodeUnselected: function (event, node) {
                        console.log(node);
                    }
                });
            }
        </script>
    @else
        <div class="treeview" class="" name="{{ $row->field }}"></div>
    @endif
@else
    <?php $selected_value = (isset($dataTypeContent->{$row->field}) && !is_null(old($row->field, $dataTypeContent->{$row->field}))) ? old($row->field, $dataTypeContent->{$row->field}) : old($row->field); ?>
    <div id="treeview-{{ $row->field }}" class=""></div>
    <?php $default = (isset($options->default) && !isset($dataTypeContent->{$row->field})) ? $options->default : null; ?>
    @if(isset($options->options))
    @endif
@endif
