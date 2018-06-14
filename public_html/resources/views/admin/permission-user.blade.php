@foreach($user_permission as $item)
<li><a href="{{URL::asset('')}}{{$item->link}}"><i class="fa fa-home"></i> {{$item->permission}}</a>
</li>
@endforeach