<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Bedrijf toevoegen</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f9f9f9; }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    h1 { color: #333; }
    form {
      background: white;
      padding: 20px;
      border-radius: 12px;
      width: 400px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      margin-top: 20px;
    }
    label { display: block; margin-top: 15px; font-weight: bold; }
    input, button {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    button {
      background: green;
      color: white;
      border: none;
      cursor: pointer;
      font-weight: bold;
    }
    button:hover { background: darkgreen; }
    .btn {
      padding: 10px 15px;
      background: gray;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
    }
    .btn:hover { background: black; }
  </style>
</head>
<body>
  <header>
    <h1>➕ Bedrijf toevoegen</h1>
    <a href="overzicht.php" class="btn">⬅ Terug naar overzicht</a>
  </header>

  <form action="opslaan.php" method="post" enctype="multipart/form-data">
    <label for="bedrijf">Bedrijfsnaam:</label>
    <input type="text" id="bedrijf" name="bedrijf" required>

    <label for="uitstoot">CO₂-uitstoot (ton/jaar):</label>
    <input type="number" id="uitstoot" name="uitstoot" required>

    <label for="elektriciteit">Elektriciteitsgebruik (kWh/jaar):</label>
    <input type="number" id="elektriciteit" name="elektriciteit" required>

    <label for="bron">Bron:</label>
    <input type="text" id="bron" name="bron" required>

    <label for="logo">Bedrijfslogo (PNG/JPG):</label>
    <input type="file" id="logo" name="logo" accept="image/*" required>

    <button type="submit">Opslaan</button>
  </form>
</body>
</html>
