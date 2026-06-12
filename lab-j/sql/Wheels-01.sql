create table wheels
(
    id integer not null
        constraint wheels_pk
            primary key autoincrement,
    brand text not null,
    size integer not null,
    color text not null
);
