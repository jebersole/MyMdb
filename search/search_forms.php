
                <!-- form to search for every movie by a given actor -->
                <form action="/mymdb/search/search_all.php" method="get">
                    <fieldset>
                    <legend>All movies</legend>
                    <div>
                        <input name="firstname" type="text" size="12" placeholder="first name" autofocus="autofocus" />
                        <input name="lastname" type="text" size="12" placeholder="last name" />
                        <input type="submit" value="go" />
                    </div>
                    </fieldset>
                </form>

                <!-- form to search for movies where a given actor was with Kevin Bacon -->
                <form action="/mymdb/search/search_kevin.php" method="get">
                    <fieldset>
                    <legend>Movies with Kevin Bacon</legend>
                    <div>
                        <input name="firstname" type="text" size="12" placeholder="first name" />
                        <input name="lastname" type="text" size="12" placeholder="last name" />
                        <input type="submit" value="go" />
                    </div>
                    </fieldset>
                </form>

            </div> <!-- end of #main div -->

            <div id="footer"></div>
        </div> <!-- end of #frame div -->
    </body>
</html>
