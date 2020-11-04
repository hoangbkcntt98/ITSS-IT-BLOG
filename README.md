# Hướng dẫn chạy
- Vào xampp hoặc workbench tạo 1 tài khoản root không cần mật khẩu ( Xampp thì k cần tạo cứ thể làm làm).
- Tạo instance của tài khoản ( nếu xampp thì k cần).
- Tạo 1 database tên là "database"
- chạy php artisan migrate // Đoạn này ông nào dùng workbench bị lỗi thì chạy dòng sql này : ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password
BY 'nhập pass vào đây/ không có để trống';  
- vẫn lỗi thì copy cái php.ini vào ~/xampp/php/
- php artisan db:seed
- chạy npm install && npm run dev
- php artisan serve
- Cài đặt file .env(xóa example đi :)): Thay đoạn này vào
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database
DB_USERNAME=root
DB_PASSWORD=
- php artisan key:gen
- php artisan serve 
- Mở localhost:8000 lên
# Cách tạo một view 
- Các phần cơ bản của trang ( không thay đổi) t để trong views/layouts. à ông nào làm cái sidebar thì đổ vào cái sidebar trong này nhé.
- Nhìn file resource/views/home.blade sửa theo ( tức là chỉ cần tạo cái secsion content giống thế xong nhét dữ liệu vào thôi  ).
# Fake dữ liệu
- composer dump-autoload
- php artisan migrate:reset
- php artisan migrate
- php artisan db:seed
# Happy Coding 
