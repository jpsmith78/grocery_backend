# Shopping List Back End

## [link to list site](https://shopping-back.herokuapp.com/list)


## [link to refrigerator site](https://shopping-back.herokuapp.com/refrigerator)

## Technologies Used
PHP, PostgresSQL, Mamp, Composer,
vlucas/phpdotenv, CORS
## Approach Taken
This was my first time using PHP, so it took a little while getting Mamp server up and running and figuring out how to use the correct headers to tie it in with my front end.  Besides that, it's a pretty straightforward controllers/models layout.
## Wins
I got my routes set up pretty easily for both models and I am very comfortable writing in SQL now. I also learned quite a bit about using composer's dotenv files.
## Difficulties
My main stumbling block was figuring out how to get my CORS headers to work correctly.  I placed them in my controllers, which worked for my GET routes, but not for any of the others.  After two days of googling, it was discovered that I had to place my CORS headers at the top of my .htaccess file and not my controllers.  I also had to put my content type header in the .htaccess as well as both controllers.
The other thing that I struggled with later on was trying to get the many to one relationship to work correctly when objects aren't ordered by id.  I didn't solve this, but it seemed like it wasn't something that would come very often up since the application uses more of a one to one relationship almost all of the time.  Still, something to fix later.

## Future Additions
I would definitely like to fix the above mentioned many to one relationship, and I would like to add a user register and login so all users don't have to share one list.
