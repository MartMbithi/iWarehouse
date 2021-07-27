<?php
/*
 * Created on Tue Jul 27 2021
 *
 * The MIT License (MIT)
 * Copyright (c) 2021 MartDevelopers Inc
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial
 * portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

/* Users */
$query = "SELECT COUNT(*)  FROM `users` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($users);
$stmt->fetch();
$stmt->close();

/* Customers */
$query = "SELECT COUNT(*)  FROM `customer` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($customers);
$stmt->fetch();
$stmt->close();


/* Categories */
$query = "SELECT COUNT(*)  FROM `categories` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($categories);
$stmt->fetch();
$stmt->close();

/* Products */
$query = "SELECT COUNT(*)  FROM `product` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($products);
$stmt->fetch();
$stmt->close();

/* Stores */
$query = "SELECT COUNT(*)  FROM `store` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($stores);
$stmt->fetch();
$stmt->close();


/* Customer Orders */
$query = "SELECT COUNT(*)  FROM `order_table` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($orders);
$stmt->fetch();
$stmt->close();
