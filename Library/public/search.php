<html>
<head>
<title>Book Search</title>
</head>
<body>
<h1>Search for books</h1>
<form action="results.php" method="post">
Search by:<br />
<select name="searchtype">
<option name="author" value="author">Author</option>
<option name="title" value="title">Title</option>
</select>
<br />
Enter Search Term:<br />
<input type=”"text" name="searchterm" size="40"/>
<br />
<input type="submit" name="submit" value="Search"/>
</form>
</body>
</html>