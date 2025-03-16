create database blog_db;

create table users
(
    id       int auto_increment
        primary key,
    email    varchar(255) not null,
    password varchar(255) not null,
    constraint email
        unique (email)
);

create table posts
(
    id         int auto_increment
        primary key,
    user_id    int                                 not null,
    title      varchar(255)                        not null,
    content    text                                not null,
    created_at timestamp default CURRENT_TIMESTAMP not null,
    constraint posts_ibfk_1
        foreign key (user_id) references users (id)
            on delete cascade
);

create index user_id
    on posts (user_id);

