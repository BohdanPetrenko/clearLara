<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title></title>
</head>
<body>

<form method="POST" action="{{ route('jirafilters.store') }}">
    @csrf
    <select name="filter_id">
        @foreach ($jiraFilters as $filter)
            <option value="{{ $filter['id'] }}">{{ $filter['name'] }}</option>
        @endforeach
    </select>

    <div class="form-group mx-sm-3 mb-2">
        <input name="schedule" placeholder="Cron format">
    </div>
    <div class="form-group mx-sm-3 mb-2">
        <label for="max_total_items" class="sr-only"></label>
        <input name="max_total_items"
               placeholder="Send an alert when the number of tasks exceeds the specified limit">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Confirm</button>
</form>


<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>
