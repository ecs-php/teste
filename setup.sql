create schema app;
use app;
create table jobs (
	idjob int auto_increment primary key,
    name varchar(100) not null,
    description text,
    requirements text,
    initial_salary double not null,
    updated_at timestamp not null,
    created_at timestamp not null
);