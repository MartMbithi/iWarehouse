<?php
/*
 * Created on Fri Jul 09 2021
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


/* System Generated Password */
$sys_gen_password = substr(
    str_shuffle("QWERTYUIOPLKJHGF#$%^DSAZXCVBNM1234567890`!@&*()_,?qwertyuioplkjhgfd+|}{:';/.sazxcvbnm"),
    1,
    8
);

/* SysGenerated Payment Codes */
$sys_gen_paycode = substr(
    str_shuffle("QWERTYUIOPLKJHGFDSAZXCVBNM1234567890"),
    1,
    10
);
/* System Generated ID */
$length = date('y');
$sys_gen_id = bin2hex(random_bytes($length));

/* Alternative Sys Generated ID 1 */
$length = date('y');
$sys_gen_id_alt_1 = bin2hex(random_bytes($length));

/* Alternative System Generated ID 2 */
$length = date('y');
$sys_gen_id_alt_2 = bin2hex(random_bytes($length));
/* System Generated Codes */
$a = substr(str_shuffle("QWERTYUIOPLKJHGFDSAZXCVBNM"), 1, 5);
$b = substr(str_shuffle("1234567890"), 1, 5);
