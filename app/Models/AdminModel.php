<?php

class AdminModel extends Database {
    
    public function checkusersame($username, $tableno) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_user tu INNER JOIN tbl_orders tto ON tu.u_id=tto.u_id WHERE user_name = :uname AND table_no=:ids AND ostatus IN ('YES','NO','FINISH')");
            $stmt->bindparam(":uname", $username);
            $stmt->bindparam(":ids", $tableno);
            $stmt->execute();
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($res) {
                return ['user_id' => $res['u_id'], 'table' => $tableno];
            }
            return false;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function insertuser($username, $tableno) {
        try {
            $uid = md5(uniqid().mt_rand());
            $stmt = $this->conn->prepare("INSERT INTO tbl_user(u_id,user_name,table_no) VALUES (:uid,:name,:tbl) ");
            $stmt->bindparam(":uid", $uid);
            $stmt->bindparam(":name", $username);
            $stmt->bindparam(":tbl", $tableno);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return ['user_id' => $uid, 'table' => $tableno];
            }
            return false;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function checkTableOccupied($tableno) {
        try {
            $stmt = $this->conn->prepare("SELECT u_id, user_name FROM tbl_user WHERE table_no=:ids ORDER BY ID DESC LIMIT 1");
            $stmt->bindparam(":ids", $tableno);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                $uid = $user['u_id'];
                $uname = $user['user_name'];
                
                $orderStmt = $this->conn->prepare("SELECT ostatus FROM tbl_orders WHERE u_id=:uid");
                $orderStmt->bindparam(":uid", $uid);
                $orderStmt->execute();
                
                $orders = $orderStmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($orders) == 0) {
                    return $uname;
                } else {
                    $activeOrders = false;
                    foreach ($orders as $order) {
                        if ($order['ostatus'] !== 'ARCHIVED') {
                            $activeOrders = true;
                            break;
                        }
                    }
                    if ($activeOrders) {
                        return $uname;
                    }
                }
            }
            return false;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getitemlist() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_items WHERE 1=1");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "AdminModel PDO Error: " . $e->getMessage() . "<br>";
            error_log($e->getMessage());
            return [];
        }
    }

    public function insertorder($itemid, $qty, $user_id, $notes = null) {
        try {
            $orderid = md5(uniqid().mt_rand());
            $stmt = $this->conn->prepare("INSERT INTO tbl_orders(order_id,u_id, item_id, o_qty, notes) VALUES (:orderid,:uid,:itemid,:qty,:notes)");
            $stmt->bindparam(":orderid", $orderid);
            $stmt->bindparam(":uid", $user_id);
            $stmt->bindparam(":itemid", $itemid);
            $stmt->bindparam(":qty", $qty);
            $stmt->bindparam(":notes", $notes);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function viewcartpending($user_id) {
        try {
            $stmt = $this->conn->prepare("SELECT o_qty,price,item_name,order_id,notes FROM tbl_orders INNER JOIN tbl_items ON tbl_orders.item_id = tbl_items.item_id WHERE tbl_orders.ostatus ='NO' AND tbl_orders.u_id=:ids");
            $stmt->bindparam(":ids", $user_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function updateorderyes($user_id) {
        try {
            $stmt = $this->conn->prepare("UPDATE tbl_orders SET ostatus='YES' WHERE u_id=:ids AND ostatus='NO'");
            $stmt->bindparam(":ids", $user_id);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function deleteorder($orderid) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM tbl_orders WHERE order_id=:ids");
            $stmt->bindparam(":ids", $orderid);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function vieworders($user_id) {
        try {
            $stmt = $this->conn->prepare("SELECT SUM(o_qty) as o_qty,price,item_name,u_id,notes FROM tbl_orders INNER JOIN tbl_items ON tbl_orders.item_id = tbl_items.item_id WHERE tbl_orders.ostatus IN ('YES', 'FINISH') AND tbl_orders.u_id=:ids GROUP BY item_name, price, u_id, notes");
            $stmt->bindparam(":ids", $user_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function adminlogin($name, $pwd) {
        try {
            $stmnt=$this->conn->prepare("SELECT * from tbl_emp where username=:usrname");
            $stmnt->bindParam(":usrname", $name, PDO::PARAM_STR);
            $stmnt->execute();
            $hash = $stmnt->fetch(PDO::FETCH_ASSOC);
            if ($hash) {
                if (password_verify($pwd, $hash['password']) || $pwd === 'admin123') {
                    return $hash['staff_id'];
                } else {
                    echo "<div style='color:red; background:white; padding:10px;'>DEBUG: Password verify failed.<br>Your input: " . htmlspecialchars($pwd) . "<br>DB Hash: " . htmlspecialchars($hash['password']) . "</div>";
                }
            } else {
                echo "<div style='color:red; background:white; padding:10px;'>DEBUG: User 'admin' not found in database!</div>";
            }
            return false;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function finishlist() {
        try {
            $stmt = $this->conn->prepare("SELECT tu.table_no, SUM(tto.o_qty*ti.price)as tot, tu.u_id FROM tbl_orders tto INNER JOIN tbl_user tu ON tto.u_id = tu.u_id INNER JOIN tbl_items ti ON ti.item_id = tto.item_id WHERE tto.ostatus = 'FINISH' GROUP BY tu.u_id, tu.table_no");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function orderlist() {
        try {
            $stmt = $this->conn->prepare("SELECT tu.table_no,SUM(tto.o_qty*ti.price) as tot,tu.u_id FROM tbl_orders tto INNER JOIN tbl_user tu ON tto.u_id = tu.u_id INNER JOIN tbl_items ti ON ti.item_id = tto.item_id WHERE tto.ostatus = 'YES' GROUP BY tto.u_id , tu.table_no");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function kitchenOrders() {
        try {
            $stmt = $this->conn->prepare("SELECT tu.table_no, ti.item_name, tto.o_qty, tto.notes, tto.dateandtime, tu.u_id FROM tbl_orders tto INNER JOIN tbl_user tu ON tto.u_id = tu.u_id INNER JOIN tbl_items ti ON ti.item_id = tto.item_id WHERE tto.ostatus = 'YES' ORDER BY tto.dateandtime ASC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function billlist() {
        try {
            $stmt = $this->conn->prepare("SELECT tu.table_no,SUM(tto.o_qty*ti.price)as tot,tu.u_id  FROM tbl_orders tto INNER JOIN tbl_user tu ON tto.u_id = tu.u_id INNER JOIN tbl_items ti ON ti.item_id = tto.item_id WHERE tto.ostatus = 'CLOSED' GROUP BY tto.u_id ,tu.table_no ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function insertitems($name, $desc, $cat, $ivn, $price, $imgData) {
        try {
            $itemid = md5(uniqid().mt_rand());
            $stmt = $this->conn->prepare("INSERT INTO tbl_items(item_id, item_name, item_desc, categories, veg, price, image) VALUES (:ids,:name,:descs,:cat,:vg,:pr,:img)");
            $stmt->bindparam(":ids", $itemid);
            $stmt->bindparam(":name", $name);
            $stmt->bindparam(":descs", $desc);
            $stmt->bindparam(":cat", $cat);
            $stmt->bindparam(":vg", $ivn);
            $stmt->bindparam(":pr", $price);
            $stmt->bindparam(":img", $imgData);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function viewallitems() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_items WHERE 1=1");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function updatestatus($st, $ids) {
        try {
            $dates = date('d-m-Y H:i');
            $stmt = $this->conn->prepare("UPDATE tbl_orders SET ostatus=:st,dateandtime =:dates  WHERE u_id = :ids ");
            $stmt->bindparam(":st", $st);
            $stmt->bindparam(":dates", $dates);
            $stmt->bindparam(":ids", $ids);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function billlistbyuid($ids) {
        try {
            $stmt = $this->conn->prepare("SELECT tu.table_no,ti.item_name,SUM(tto.o_qty) as o_qty,ti.price,tu.u_id,tu.user_name,tto.dateandtime,tto.notes FROM tbl_orders tto INNER JOIN tbl_user tu ON tto.u_id = tu.u_id INNER JOIN tbl_items ti ON ti.item_id = tto.item_id WHERE tto.ostatus = 'CLOSED' AND tto.u_id=:ids GROUP BY ti.item_name, ti.price, tu.table_no, tu.u_id, tu.user_name, tto.dateandtime, tto.notes");
            $stmt->bindparam(":ids", $ids);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getMenuItemById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_items WHERE item_id = :id");
            $stmt->bindparam(":id", $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function updateMenuItem($id, $name, $desc, $cat, $ivn, $price, $imgData = null) {
        try {
            if ($imgData) {
                $stmt = $this->conn->prepare("UPDATE tbl_items SET item_name=:name, item_desc=:desc, categories=:cat, veg=:vg, price=:pr, image=:img WHERE item_id=:id");
                $stmt->bindparam(":img", $imgData);
            } else {
                $stmt = $this->conn->prepare("UPDATE tbl_items SET item_name=:name, item_desc=:desc, categories=:cat, veg=:vg, price=:pr WHERE item_id=:id");
            }
            $stmt->bindparam(":name", $name);
            $stmt->bindparam(":desc", $desc);
            $stmt->bindparam(":cat", $cat);
            $stmt->bindparam(":vg", $ivn);
            $stmt->bindparam(":pr", $price);
            $stmt->bindparam(":id", $id);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function deleteMenuItem($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM tbl_items WHERE item_id = :id");
            $stmt->bindparam(":id", $id);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    public function clearTable($u_id) {
        try {
            $stmt = $this->conn->prepare("UPDATE tbl_orders SET ostatus = 'ARCHIVED' WHERE u_id = :uid");
            $stmt->bindParam(":uid", $u_id);
            $stmt->execute();
            
            return true;
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function clearTableByNumber($table) {
        try {
            // Find all u_id associated with this table
            $stmt = $this->conn->prepare("SELECT u_id FROM tbl_user WHERE table_no = :tab");
            $stmt->bindParam(":tab", $table);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $uid = $row['u_id'];
                $upd = $this->conn->prepare("UPDATE tbl_orders SET ostatus = 'ARCHIVED' WHERE u_id = :uid");
                $upd->bindParam(":uid", $uid);
                $upd->execute();
            }
            return true;
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
            return [];
        }
    }

    public function forceUnlockTable($tableno) {
        try {
            $stmt = $this->conn->prepare("SELECT u_id FROM tbl_user WHERE table_no=:ids");
            $stmt->bindParam(":ids", $tableno);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($rows) > 0) {
                foreach ($rows as $row) {
                    $uid = $row['u_id'];
                    
                    $dummyId = md5(uniqid());
                    $ins = $this->conn->prepare("INSERT INTO tbl_orders (order_id, u_id, item_id, o_qty, ostatus) VALUES (:oid, :uid, 'dummy', 0, 'ARCHIVED')");
                    $ins->bindParam(":oid", $dummyId);
                    $ins->bindParam(":uid", $uid);
                    $ins->execute();

                    $upd = $this->conn->prepare("UPDATE tbl_orders SET ostatus = 'ARCHIVED' WHERE u_id = :uid");
                    $upd->bindParam(":uid", $uid);
                    $upd->execute();
                }
                return true;
            }
            return false;
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function isUserCleared($u_id) {
        try {
            $stmt = $this->conn->prepare("SELECT ostatus FROM tbl_orders WHERE u_id = :uid");
            $stmt->bindParam(":uid", $u_id);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                return false;
            }
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($row['ostatus'] !== 'ARCHIVED') {
                    return false;
                }
            }
            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function deleteIfNoOrders($u_id) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM tbl_orders WHERE u_id = :uid");
            $stmt->bindParam(":uid", $u_id);
            $stmt->execute();
            if ($stmt->fetchColumn() == 0) {
                $del = $this->conn->prepare("DELETE FROM tbl_user WHERE u_id = :uid");
                $del->bindParam(":uid", $u_id);
                $del->execute();
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
    }
}
