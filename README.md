# OnlineHighScore
PHP code to maintain and update a high score file.

* The filename is "HiScore.txt" and must have permissions rw-rw-rw-
* This php file is stored on the server, along with the highscore file.
* All player names are capitalized
* Scores are automatically sorted
* Only the top 10 are kept
* The correct authorization code must be used in order to udpate the file
* There is no feature (yet) to reset the file (delete all contents)
* Player scores will be updated correctly if the player gets a new high score.

## Data validation: 

* Both name and score must be present and non-zero length.
* Scores must be numeric.  
* I have not tested it with decimal scores, and don't intend to.
* Input is not sanitized for HTML or SQL injection since this does not use SQL. It's a plain text file.
