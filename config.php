<?php
session_start();
/**
 * Lashopak
 */
class lashopak
{
    function __construct()
    {
        $driver     = "mysql";
        $host       = "localhost";
        $dbname     = "tokolapak";
        $charset    = "utf8mb4";

        $user       = "root";
        $pw         = "";
        $options    = NULL;

        $dsn        = "${driver}:host=${host};dbname=${dbname};charset=${charset}";

        try {
            $this->db = new PDO($dsn, $user, $pw, $options);
        } catch (\PDOExpection $e) {
            throw new \PDOExpection($e->getMassage(), (int)$e->getCode());
        }
    }

    public function getDB()
	{
		return $this->db;
	}

    public function registeradd($nama, $username, $email, $hashed)
    {
        $query = "INSERT INTO admin(nama, email, username, password) VALUES (:nama, :email, :username, :hashed)";
        $stmt = $this->db->prepare($query);
        $stmt->execute(array(':nama' => $nama, ':username' => $username, ':email' => $email, ':hashed' => $hashed));

    }

    public function loginadd($username, $pw)
    {
        $query = "SELECT * FROM admin WHERE username=:username OR email=:email LIMIT 1";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute(array(':username' => $username, ':email' => $username))) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($pw, $result['password'])) {
                $_SESSION['admin'] = $result;
            }else{
                return "Gagal";
            }
        }else{
                return "Gagal";
        }
    }

    public function login($username, $password)
    {
        $query = "SELECT * FROM member WHERE username=:username OR email=:email LIMIT 1";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute(array(':username' => $username, ':email' => $username))) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $result['password'])) {
                $_SESSION['user'] = $result;
            }
        }
    }

    public function register($name, $username, $hashed, $email, $telp, $alamat, $profil)
    {
        if (!empty($profil)) {
            $namapp = $profil['name'];
            $tmploc = $profil['tmp_name'];

            $allowed     = array('png', 'jpg', 'jpeg');
            $x           = explode('.', $namapp);
            $eks         = strtolower(end($x));
            $newfilename = mt_rand(1,99).$username.'.'.$eks;
            if (in_array($eks, $allowed) === TRUE) {
                move_uploaded_file($tmploc, 'img/prod/'.$newfilename);
            }
            $query = "INSERT INTO member(nama, username, password, email, telp, address, profil) VALUES (:nama, :username, :password, :email, :telp, :address, :profil)";
            $stmt = $this->db->prepare($query);
            $stmt->execute(array(':nama' => $name, ':username' => $username, ':password' => $hashed, ':email' => $email, ':telp' => $telp, ':address' => $alamat, ':profil' => $newfilename));
            return "Berhasil";
        }else{
            $query = "INSERT INTO member(nama, username, password, email, telp, address) VALUES (:nama, :username, :password, :email, :telp, :address)";
            $stmt = $this->db->prepare($query);
            $stmt->execute(array(':nama' => $name, ':username' => $username, ':password' => $hashed, ':email' => $email, ':telp' => $telp, ':address' => $alamat));
            return "Berhasil";
        }
    }

    public function newCategory($cat)
    {
        $query = "INSERT INTO kategori(namaktg) VALUES (:nama)";
        $stmt = $this->db->prepare($query);
        $stmt->execute(array(':nama' => $cat));
    }

    public function showCategory()
    {
        $query = "SELECT * FROM kategori";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute()) {
            return $stmt;
        }
    }
    
    public function addProduct($poto, $nama, $desc, $category, $price, $stock)
    {
        // PP
        $namapp = $poto['name'];
        $tmploc = $poto['tmp_name'];
        
        $allowed        = array('png', 'jpg', 'jpeg');
        $x              = explode('.', $namapp);
        $eks            = strtolower(end($x));
        $newfilename    = mt_rand(1,99).'-'.$price.'-'.$stock.'.'.$eks;

        $tanggal        = date("Y-m-d");

        if (in_array($eks, $allowed) === TRUE) {
			move_uploaded_file($tmploc, '../img/prod/'.$newfilename);
				$sql = "INSERT INTO produk (poto, namaprod, deskprod, hargabrg, jumlahbrg, kategori, upload) VALUES (:poto, :namaprod, :deskprod, :hargabrg, :jumlahbrg, :kategori, :upload)";
				$stmt = $this->db->prepare($sql);
				$stmt->execute(array(':poto' => $newfilename, ':namaprod' => $nama, ':deskprod' => $desc, ':hargabrg' => $price, ':jumlahbrg' => $stock, ':kategori' => $category, ':upload' => $tanggal));
				if (!$stmt) {
					return "Gagal";
				}else{
					return "Sukses";
				}
		}else{
			return "EKSGagal";
		}
    }

    public function getProd()
    {
        $query = "SELECT * FROM produk";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute()) {
            return $stmt;
        }
    }

    public function getCat()
    {
        $query = "SELECT * FROM kategori";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute()) {
            return $stmt;
        }
    }

    public function detProd($idProd)
    {
        $query = "SELECT * FROM produk WHERE id=:id";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute(array(':id' => $idProd))) {
            return $stmt;
        }
    }

    public function addCart($memberID, $prodID, $nama, $harga, $jumlah, $total, $note)
    {
        $check = "SELECT * FROM cart WHERE memberID=:memberID AND prodID=:prodID";
        $stmt2 = $this->db->prepare($check);
        $stmt2->execute(array(':memberID' => $memberID, ':prodID' => $prodID));
        $count = $stmt2->rowCount();
        if ($count == 0) {
            $query = "INSERT INTO cart(memberID, prodID, nama, harga, jumlah, total, note) VALUES
                        (:memberID, :prodID, :nama, :harga, :jumlah, :total, :note)";
            $stmt = $this->db->prepare($query);
            $stmt->execute(array(':memberID' => $memberID, ':prodID' => $prodID, ':nama' => $nama, ':harga' => $harga,
                 ':jumlah' => $jumlah, ':total' => $total, ':note' => $note));
            if (!$stmt) {
                return "Gagal";
            }else{
                return "Sukses";
            }   
        }else{
            $data = $stmt2->fetch(PDO::FETCH_OBJ);
            $jumlahLama = $data->jumlah;
            $jumlahBaru = ((int)$jumlahLama + (int)$jumlah);
            $totalBaru = ((int)$jumlahBaru * (int)$harga);
            $query = "UPDATE cart SET jumlah=:jumlah, total=:total WHERE memberID=:memberID AND prodID=:prodID";
            $stmt = $this->db->prepare($query);
            $stmt->execute(array(':jumlah' => $jumlahBaru, ':total' => $totalBaru, ':memberID' => $memberID, ':prodID' => $prodID));
            if (!$stmt) {
                return "Gagal";
            }else{
                return "Sukses";
            }
        }
    }

    public function countCart()
	{
		$query = "SELECT * FROM cart WHERE memberID=:id";
		$stmt = $this->db->prepare($query);
		if ($stmt->execute(array(':id' => $_SESSION['user']['id']))) {
			$count = $stmt->rowCount();
			return $count;
		}

    }

    public function deleteOrder($transCode)
    {
        $query = "DELETE FROM transaksi WHERE transCode=:transCode";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute(array(':transCode' => $transCode))) {
            return "Sukses";
        }
    }

    public function countAdmin()
    {
        $query = "SELECT * FROM admin";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute()) {
            $count = $stmt->rowCount();
            return $count;
        }
    }

    public function searchProd($query)
    {
        $likes = [];
        foreach ($query as $quest) {
            $likes[] = "'%".trim($quest)."%'";
        }

        $sql = "SELECT * FROM produk";

        if (!empty($likes)) {
            $sql .= " WHERE namaprod LIKE "
                .array_shift($likes)
                .implode(" OR deskprod LIKE ", $likes);
        }
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute()) {
            return $stmt;
        }
    }

    public function countUser()
    {
        $query = "SELECT * FROM member";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute()) {
            $count = $stmt->rowCount();
            return $count;
        }
    }

    public function countProd()
    {
        $query = "SELECT * FROM produk";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute()) {
            $count = $stmt->rowCount();
            return $count;
        }
    }

    public function countTrans()
    {
        $query = "SELECT * FROM transaksi GROUP BY transCode";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute()) {
            $count = $stmt->rowCount();
            return $count;
        }
    }

    public function addPayment($poto,$transCode)
    {
        // PP
        $namapp = $poto['name'];
        $tmploc = $poto['tmp_name'];

        $allowed        = array('png', 'jpg', 'jpeg');
        $x              = explode('.', $namapp);
        $eks            = strtolower(end($x));

        $tanggal        = date("Y-m-d");

        function acak($panjang)
        {
            $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456890';
            $string	  = '';

            for ($i=0; $i < $panjang; $i++) { 
                $pos = rand(0, strlen($karakter)-1);
                $string .= $karakter{$pos};
            };
            return $string;
        };
        $random = acak(16);

        $newfilename    = $random.'.'.$eks;

        if (in_array($eks, $allowed) === TRUE) {
			move_uploaded_file($tmploc, 'img/bukti/'.$newfilename);
				$sql = "UPDATE transaksi SET bukti=:bukti WHERE transCode=:transCode";
				$stmt = $this->db->prepare($sql);
				$stmt->execute(array(':bukti' => $newfilename, ':transCode' => $transCode));
				if (!$stmt) {
					return "Gagal";
				}else{
					return "Sukses";
				}
		}else{
			return "EKSGagal";
		}
    }

    public function transUserOnly($memID)
    {
        $query = "SELECT * FROM transaksi WHERE memberID=:memID GROUP BY transCode";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute(array(':memID' => $memID))) {
            $count = $stmt->rowCount();
            return $count;
        }
    }

    public function transOnce($transCode)
    {
        $query = "SELECT * FROM transaksi WHERE transCode=:transCode GROUP BY transCode";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute(array(':transCode' => $transCode))) {
            return $stmt;
        }
    }

    public function showTrans()
    {
        $query = "SELECT * FROM transaksi GROUP BY transCode ORDER BY tglTrans ASC";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute()) {
            return $stmt;
        }
    }

    public function getTransUser($memID)
    {
        $query = "SELECT * FROM member WHERE id=:memID";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute(array(':memID' => $memID))) {
            return $stmt;
        }
    }

    public function getTransUserOnly($memID, $transCode)
    {
        $query = "SELECT * FROM member WHERE id=:memID";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute(array(':memID' => $memID))) {
            return $stmt;
        }
    }

    public function getTransReal($transCode)
    {
        $query = "SELECT * FROM transaksi WHERE transCode=:transCode";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute(array(':transCode' => $transCode))) {
            return $stmt;
        }
    }
    
    public function showCart($memID)
    {
        $query = "SELECT * FROM cart WHERE memberID=:id";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute(array(':id' => $memID))) {
            return $stmt;
        }
    }

    public function showUser()
    {
        $query = "SELECT * FROM member";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute()) {
            return $stmt;
        }
    }

    public function cartImage($productID)
    {
        $query = "SELECT poto FROM produk WHERE id=:id";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute(array(':id' => $productID))) {
            return $stmt;
        }
    }

    public function addStatus($status, $transCode)
    {
        $query = "UPDATE transaksi SET status=:status WHERE transCode=:transCode";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute(array(':status' => $status, ':transCode' => $transCode))) {
            return "Sukses";
        }else{
            return "Gagal";
        }
    }

    public function cartTotal($memID)
    {
        $query = "SELECT sum(total) AS priceSum FROM cart WHERE memberID=:id";
		$stmt = $this->db->prepare($query);
		if ($stmt->execute(array(':id' => $memID))) {
			return $stmt;
		}
    }

    public function transTotal($transCode)
    {
        $query = "SELECT sum(total) AS priceSum FROM transaksi WHERE transCode=:id";
		$stmt = $this->db->prepare($query);
		if ($stmt->execute(array(':id' => $transCode))) {
			return $stmt;
		}
    }

    public function addToTrans($cartID, $memID, $prodID, $transCode, $tglTrans, $nama, $harga, $jumlah, $total, $note)
    {
        $query = "INSERT INTO transaksi(memberID, prodID, transCode, tglTrans, nama, harga, jumlah, total, note) VALUES 
        (:memID, :prodID, :transCode, :tglTrans, :nama, :harga, :jumlah, :total, :note)";
        $stmt = $this->db->prepare($query);
        $index = 0;
        foreach ($memID as $dataID) {
        // if ($stmt->execute(array(':memID' => $memID,
        //                          ':prodID' => $prodID,
        //                          ':transCode' => $transCode, 
        //                          ':tglTrans' => $tglTrans, 
        //                          ':nama' => $nama, 
        //                          ':harga' => $harga, 
        //                          ':jumlah' => $jumlah, 
        //                          ':total' => $total, 
        //                          ':catatan' => $note))) {
        //     $delQuery = "DELETE FROM cart WHERE memberID=:memID AND prodID=:prodID";
        //     $stmt2 = $this->db->prepare($delQuery);
        //     if($stmt2->execute(array(':memID' => $memID, ':prodID' => $prodID))){
        //         return "Sukses";
        //     }else{
        //         return "Gagal";
        //     }
        // }else{
        //     return "Gagal";
        // }
            $stmt->bindParam(':memID', $dataID);
            $stmt->bindParam(':prodID', $prodID[$index]);
            $stmt->bindParam(':transCode', $transCode[$index]);
            $stmt->bindParam(':tglTrans', $tglTrans[$index]);
            $stmt->bindParam(':nama', $nama[$index]);
            $stmt->bindParam(':harga', $harga[$index]);
            $stmt->bindParam(':jumlah', $jumlah[$index]);
            $stmt->bindParam(':total', $total[$index]);
            $stmt->bindParam(':note', $note[$index]);
            $stmt->execute();

            $index++;
        }
    }

    public function delProd($id)
    {
        $query = "DELETE FROM produk WHERE id=:id";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute(array(':id' => $id))) {
            return "Sukses";
        }
    }

    public function delCat($id)
    {
        $query = "DELETE FROM kategori WHERE id=:id";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute(array(':id' => $id))) {
            return "Sukses";
        }
    }
}


?>