
    @foreach($filters as $filter)
        <tr>
           {{ $filter['name'] }}
            {{ $filter['id'] }}
            <br>
        </tr>
    @endforeach
