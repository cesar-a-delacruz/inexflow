
create table businesses
(
    id         binary(16)   not null primary key,
    name       varchar(255) not null,
    phone      varchar(255) not null,
    created_at datetime     not null,
    updated_at datetime     not null,
    deleted_at datetime     null
);

create table users
(
    id            binary(16) primary key                              not null,
    business_id   binary(16)                                          null
    name          varchar(255)                                        not null,
    email         varchar(255)                                        not null,
    password_hash char(60)                                            not null,
    role          enum ('admin', 'businessman') default 'businessman' not null,
    is_active     tinyint(1)                    default 1             not null,
    created_at    datetime                                            not null,
    updated_at    datetime                                            not null,
    deleted_at    datetime                                            null,
    constraint foreign key (business_id) references businesses (id)
);

create table measure_units
(
    id    serial primary key,
    value varchar(255) not null
);

create table items
(
    id              serial primary key,
    business_id     binary(16)                                     not null,
    name            varchar(255)                                   not null,
    type            enum ('product', 'supplies') default 'product' not null,
    cost            decimal(10, 2)               default 0.00      not null,
    selling_price   decimal(10, 2)                                 null,
    stock           int unsigned                         default 0         null,
    min_stock       int unsigned                         default 10         null,
    measure_unit_id bigint unsigned                                not null,
    created_at      datetime                                       not null,
    updated_at      datetime                                       not null,
    deleted_at      datetime                                       null,
    constraint foreign key (measure_unit_id) references measure_units (id),
    constraint foreign key (business_id) references businesses (id)
);


create table services
(
    id              serial primary key,
    business_id     binary(16)                  not null,
    category_id     bigint unsigned             null,
    name            varchar(255)                not null,
    type            enum ('income', 'expose')   not null,
    cost            decimal(10, 2) default 0.00 not null,
    selling_price   decimal(10, 2)              null,
    measure_unit_id bigint unsigned             not null,
    created_at      datetime                    not null,
    updated_at      datetime                    not null,
    deleted_at      datetime                    null,
    constraint foreign key (category_id) references categories (id),
    constraint foreign key (measure_unit_id) references measure_units (id),
    constraint foreign key (business_id) references businesses (id)
);

create table categories
(
    id          serial primary key,
    name        varchar(255) not null,
    business_id binary(16)   not null,
    created_at  datetime     not null,
    updated_at  datetime     not null,
    deleted_at  datetime     null,
    constraint unique (business_id, name),
    constraint foreign key (business_id) references businesses (id)
);

create table categories_items
(
    business_id binary(16)      not null,
    category_id bigint unsigned not null,
    item_id     bigint unsigned not null,
    constraint primary key (category_id, item_id),
    constraint foreign key (business_id) references businesses (id),
    constraint foreign key (category_id) references categories (id),
    constraint foreign key (item_id) references items (id),
);

create table contacts
(
    id          serial primary key,
    business_id binary(16)                                       not null,
    name        varchar(255)                                     not null,
    email       varchar(255)                                     null,
    phone       varchar(50)                                      null,
    address     text                                             null,
    type        enum ('customer', 'provider') default 'customer' not null,
    created_at  datetime                                         not null,
    updated_at  datetime                                         not null,
    deleted_at  datetime                                         null,
    constraint foreign key (business_id) references businesses (id)
);


# Relación Products ↔ Ingredients.
create table recipes
(
    id              serial primary key,
    business_id     binary(16)        not null,
    product_id      bigint unsigned   not null,
    ingredient_id   bigint unsigned   not null,
    quantity        smallint unsigned not null,
    measure_unit_id bigint unsigned   not null,
    created_at  datetime                                         not null,
    updated_at  datetime                                         not null,
    deleted_at  datetime
    constraint foreign key (business_id) references businesses (id),
    constraint foreign key (product_id) references items (id),
    constraint foreign key (ingredient_id) references items (id),
    constraint foreign key (measure_unit_id) references measure_units (id)
);

# Una tabla común para todos los tipos de inventario.
# (Así no repites lógica de entradas/salidas en cada tabla).
create table stock_movements
(
    id            serial primary key,
    business_id   binary(16)                                          not null,
    item_id       bigint unsigned                                     not null,
    movement_type enum ('purchase','sale','consumption','adjustment') not null,
    quantity      smallint unsigned                                   not null,
    created_at    datetime                                            not null,
    constraint foreign key (item_id) references items (id),
    constraint foreign key (business_id) references businesses (id)
);

create table transactions
(
    id             serial primary key,
    number         varchar(50)                                                     not null comment 'Correlativo por negocio',
    business_id    binary(16)                                                      not null,
    contact_id     bigint unsigned                                                 null comment 'NULL para venta sin cliente',
    payment_status enum ('paid', 'pending', 'overdue', 'cancelled') default 'paid' not null,
    description    varchar(255)                                                    not null,
    due_date       date                                                            null comment 'Fecha de vencimiento para crédito',
    total          decimal(10, 2)                                                  null,
    created_at     datetime                                                        not null,
    updated_at     datetime                                                        not null,
    deleted_at     datetime                                                        null,
    constraint unique (business_id, number),
    constraint foreign key (business_id) references businesses (id),
    constraint foreign key (contact_id) references contacts (id)
);

create table records
(
    id             serial primary key,
    product_id     bigint unsigned   not null,
    business_id    binary(16)        not null,
    transaction_id bigint unsigned   not null,
    unit_price     decimal(10, 2)    not null,
    quantity       smallint unsigned not null,
    subtotal       decimal(10, 2)    not null,
    constraint foreign key (transaction_id) references transactions (id),
    constraint foreign key (product_id) references items (id),
    constraint foreign key (business_id) references businesses (id)
);

create table payments
(
    id             serial primary key,
    business_id    binary(16)                        not null,
    transaction_id bigint unsigned                   not null,
    payment_method enum ('cash', 'card', 'transfer') not null,
    amount         decimal(10, 2)                    not null,
    created_at     datetime                          not null,
    updated_at     datetime                          not null,                          not null,
    deleted_at     datetime                          null,
    constraint foreign key (transaction_id) references transactions (id),
    constraint foreign key (business_id) references businesses (id)
);
