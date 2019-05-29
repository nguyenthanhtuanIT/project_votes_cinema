http://localhost:9000/api/v1/
- Route::post('auth/google', 'Auth\AuthGoogleController@login'); // login google
input : token
- Route::get('me', 'UsersController@me'); //get infor user
input (headers) Authorization :type_token(space)token
Output : "id": 1,
    "avatar": "https://lh4.googleusercontent.com/-x949a1Z-LLU/AAAAAAAAAAI/AAAAAAAAAAA/ACHi3rfyYfUabhSeE0_lZMbIZqtjsJVSZw/mo/photo.jpg",
    "full_name": "Tuấn Nguyễn Thành",
    "username": null,
    "email": "nguyenthanhtuan.15it@gmail.com",
    "phone": null,
    "sex": null,
    "created_at": "2019-05-21 10:19:49",
    "updated_at": "2019-05-21 10:19:49".

-
    - Route::get('list_films', 'FilmsController@listFilm'); // danh sach film theo đợt vote (so sánh theo tháng năm hiện tại )
output :
 "data": [
        {
            "type": "Films",
            "id": "2",
            "attributes": {
                "name_film": "RUNNING MAN",
                "img": "Runningman.png",
                "projection_date": "2019-05-10",
                "projection_time": "120",
                "type_cinema_id": 2,
                "cinema_id": 1,
                "vote_id": 1,
                "language": "Tiếng anh",
                "age_limit": "mọi lứa tuổi",
                "detail": "Running Man là một show truyền hình hành động thực tế của Hàn Quốc, là một phần trong tổng thể chương trình Good Sunday của kênh truyền hình SBS K-pop Star. Đây là show \"hành động đô thị\" mới lạ chưa từng có. Với Running Man, đảm bảo các bạn sẽ phải cười lăn cười bò vì sự hài hước của các thành viên, cũng như những nhiệm vụ oái ăm mà họ phải chịu đựng trong suốt chương trình. MC cùng các thành viên và khách mời là những ngôi sao nổi tiếng của Hàn Quốc khám phá những địa điểm thú vị trong thành phố lẫn ngoài lãnh thổ Hàn Quốc.",
                "trailer_url": "_MOASjvA9VI",
                "price_film": 65000,
                "curency": "đ",
                "vote_number": 0,
                "register_number": 0,
                "genre": "Hành động",
                "status_vote": 1,
                "created_at": "2019-05-21T10:41:19+07:00",
                "updated_at": "2019-05-21T10:41:19+07:00",
                "deleted_at": null
            }
        }
    ]
}


    Route::post('search_films', 'FilmsController@getFilmsByDate');//tìm kiếm phim theo ngày chiếu(projection_date) or thể loại (type_cinema_id)

- Route::post('user_choose_chair', 'ChooseChairsController@choose') // lấy ra số vé của từng user để ràng buộc chọn ghế.
Input :vote_id(của hiện tại)
- Route::get('search', 'VotesController@searchByTitle');//tìm kiếm đợt xem phim theo tiêu đề (vote_name)
Input : keyword
- Route::get('status_vote', 'VotesController@showStatusVote');//status_vote_now
-Route::post('check_voted', 'VoteDetailsController@checkVoted') // check used voted
-//sum ticket
    Route::post('total_ticket', 'FilmsController@getTotalTicket');// tong so ve khi ket thuc dk
 - Route::get('random_film', 'FilmsController@randomFilm');// chon film de dk
    - Route::get('film_to_register', 'FilmsController@listMaxVote');// list film có lượt vote cao nhất (trong database phải có đợt vote có status = 2)
