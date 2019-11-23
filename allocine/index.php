<!DOCTYPE html>
<html>

<head>
  <title>Recherche</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <style>
    #search {
      padding: 2em;
    }

    #search form div input {
      padding: 10px;
    }
  </style>
</head>

<body>
  <div class="container" id="search">
    <form action="film.php" method="GET">
      <div class="form-group row">
        <label for="film" class="col-sm-1 col-form-label">Film:</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" id="film" placeholder="ex : Forrest Gump" name="film" />
        </div>
        <button type="submit" class="btn btn-primary col-md-2 col-form-label">Rechercher</button>
      </div>
    </form>
  </div>