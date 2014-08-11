use blue_cheese;
#select uid from reviews;
select email from users join feedbacks where users.uid = feedbacks.uid;