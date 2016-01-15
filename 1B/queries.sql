#the names of all the actors in the movie 'Die Another Day'

select concat(A.first,' ', A.last) 
from Actor A, MovieActor MA, (
	select id
	from Movie
	where title = 'Die Another Day'
) MovieDie
where MA.mid = MovieDie.id and A.id = MA.aid;

# the count of all the actors who acted in multiple movies
select count(aid)
from(
	select aid
	from MovieActor
	group by aid
	having count(mid) > 1
	) MultiMovieActor;

# the director and the genre of the movie 'Die Another Day'
# no record in this database
select MD.did, MG.genre
from MovieDirector MD, MovieGenre MG, (
	select id
	from Movie
	where title = 'Die Another Day'
) MovieDie
where MD.mid = MovieDie.id and MG.mid = MovieDie.id;



