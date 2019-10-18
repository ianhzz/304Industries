<?php require_once('CS304M5utility.php'); ?>
<?php
echo '<input type="button" value="Go Back To User Select" onclick="window.location=\'https://www.students.cs.ubc.ca/~cdue/cs304gp/304industries.php\'"/>';
?>
<br><br>
<h3> Welcome to the manager's config page. <br>
	On this page, you can look at our list of members, promotions, and a history of member orders.
</h3>
<h4>You can also add/remove members, promotions, and approve member orders.</h4>



<br>
<p>If you wish to reset the Clothings(Shoes, Bottoms & Tops) list, press the reset button.
	If this is the first time that you're running this page,
	you MUST use reset.</p>

<form method="POST" action="CS304M5manager.php">
	<p><input type="submit" value="Reset" name="resetClothing"></p>
</form>
<p>Add clothings with the text boxes:</p>
<p>
	<font size="2"> Clothing Type&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;Barcode&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;Materials&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;Color&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;Type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;supplierID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;Price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;Brand</font>
</p>
<form method="POST" action="CS304M5manager.php">
	<p>
		<select name="type" id="type">
			<option value="0">Select</option>
			<option value="Shoes">Shoes</option>
			<option value="Bottoms">Bottoms</option>
			<option value="Tops">Tops</option>
		</select>
		<input type="text" name="insBarcode" size="8">
		<input type="text" name="insName" size="8">
		<input type="text" name="insMaterials" size="8">
		<input type="text" name="insColor" size="8">
		<input type="text" name="insType" size="8">
		<input type="text" name="insSID" size="8">
		<input type="text" name="insPrice" size=8>
		<input type="text" name="insBrand" size="8">
		<p>Shoe Size:</p>
		<input type="text" name="insShoeSize" size="8">
		<input type="submit" value="Insert Shoes" name="insertShoes">
		<p>Waist Size&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pants Length:</p>
		<input type="text" name="inswaist" size="8">
		<input type="text" name="insBottomLength" size="8">
		<input type="submit" value="Insert Bottoms" name="insertBottoms">
		<p>Top Size:</p>
		<input type="text" name="insTopSize" size="8">
		<input type="submit" value="Insert Tops" name="insertTops">
	</p>


	<?php
	$success = True;
	$db_conn = OCILogon(
		"ora_eric1208",
		"a52835212",
		"dbhost.students.cs.ubc.ca:1522/stu"
	);

	// Connect Oracle...
	if ($db_conn) {
		if (array_key_exists('resetClothing', $_POST)) {
			// Drop old table...
			echo "<br> dropping table <br>";
			executePlainSQL("Drop table clothing cascade constraints");
			executePlainSQL("Drop table bottom");
			executePlainSQL("Drop table top");
			executePlainSQL("Drop table shoes");
			executePlainSQL("Drop table inventory");


			// Create new table...
			executePlainSQL("create table Clothing 
                        (barcode integer, name varchar2(20), Type varchar2(10) not null, color varchar2(10), materials varchar2(20),
                        supplierID integer, price real not null, brand varchar2(20), primary key (barcode),
                        foreign key (supplierID) references supplier)");
			executePlainSQL("create table Shoes
						(barcode integer, shoeSize real, primary key (barcode), 
						foreign key (barcode) references clothing on delete cascade)");
			executePlainSQL("create table Bottom
						(barcode integer, waistSize real, length real, primary key (barcode), 
						foreign key (barcode) references clothing on delete cascade)");
			executePlainSQL("create table top
						(barcode integer, sizing varchar2(10), primary key (barcode), 
						foreign key (barcode) references clothing on delete cascade)");
			executePlainSQL("create table inventory
						(barcode integer, stock integer default 0, supplierID integer, primary key (barcode), 
						foreign key (barcode) references clothing on delete cascade,
						foreign key (supplierID) references supplier)");
			OCICommit($db_conn);
		} else if (array_key_exists('insertShoes', $_POST)) {
			$tuple = array(
				":bind1" => $_POST['insBarcode'],
				":bind2" => $_POST['insName'],
				":bind3" => $_POST['insType'],
				":bind4" => $_POST['insColor'],
				":bind5" => $_POST['insMaterials'],
				":bind6" => $_POST['insSID'],
				":bind7" => $_POST['insPrice'],
				":bind8" => $_POST['insBrand']
			);
			$tuple1 = array(
				":bindA" => $_POST['insBarcode'],
				":bindB" => $_POST['insShoeSize']
			);
			$alltuples = array(
				$tuple
			);
			$alltuple1 = array(
				$tuple1
			);
			executeBoundSQL("insert into Clothing values (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6, :bind7, :bind8)", $alltuples);
			executeBoundSQL("insert into Shoes values (:bindA, :bindB)", $alltuple1);
			executeBoundSQL("insert into inventory values (:bind1, 0, :bind6)", $alltuples);
			OCICommit($db_conn);
		} else if (array_key_exists('insertBottoms', $_POST)) {
			$tuple = array(
				":bind1" => $_POST['insBarcode'],
				":bind2" => $_POST['insName'],
				":bind3" => $_POST['insType'],
				":bind4" => $_POST['insColor'],
				":bind5" => $_POST['insMaterials'],
				":bind6" => $_POST['insSID'],
				":bind7" => $_POST['insPrice'],
				":bind8" => $_POST['insBrand']
			);
			$tuple1 = array(
				":bindA" => $_POST['insBarcode'],
				":bindB" => $_POST['inswaist'],
				":bindC" => $_POST['insBottomLength']
			);
			$alltuples = array(
				$tuple
			);
			$alltuple1 = array(
				$tuple1
			);
			executeBoundSQL("insert into Clothing values (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6, :bind7, :bind8)", $alltuples);
			executeBoundSQL("insert into Bottom values (:bindA, :bindB, :bindC)", $alltuple1);
			executeBoundSQL("insert into inventory values (:bind1, 0, :bind6)", $alltuples);
			OCICommit($db_conn);
		} else if (array_key_exists('insertTops', $_POST)) {
			$tuple = array(
				":bind1" => $_POST['insBarcode'],
				":bind2" => $_POST['insName'],
				":bind3" => $_POST['insType'],
				":bind4" => $_POST['insColor'],
				":bind5" => $_POST['insMaterials'],
				":bind6" => $_POST['insSID'],
				":bind7" => $_POST['insPrice'],
				":bind8" => $_POST['insBrand']
			);
			$tuple1 = array(
				":bindA" => $_POST['insBarcode'],
				":bindB" => $_POST['insTopSize']
			);
			$alltuples = array(
				$tuple
			);
			$alltuple1 = array(
				$tuple1
			);
			executeBoundSQL("insert into Clothing values (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6, :bind7, :bind8)", $alltuples);
			executeBoundSQL("insert into Top values (:bindA, :bindB)", $alltuple1);
			executeBoundSQL("insert into inventory values (:bind1, 0, :bind6)", $alltuples);
			OCICommit($db_conn);
		}

		if ($_POST && $success) {
			//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
			header("location: CS304M5manager.php");
		} else {
			// Select data...
			$shoes = executePlainSQL("select clothing.barcode, clothing.name, clothing.materials,
								   clothing.color, clothing.type, clothing.supplierID,
								   clothing.price, clothing.brand, shoes.shoesize, inventory.stock
								   from ((clothing
								   inner join shoes on clothing.barcode = shoes.barcode)
								   inner join inventory on clothing.barcode = inventory.barcode)");
			?>
			<h6>Shoes list</h6>
			<?php
			/*printResult($result);*/
			/* next two lines from Raghav replace previous line */
			$columnNames = array("Barcode", "Name", "Materials", "Color", "Type", "Supplier ID", "Price ($)", "Brand", "Size", "Stock");
			printTable($shoes, $columnNames);

			$bottoms = executePlainSQL("select clothing.barcode, clothing.name, clothing.materials,
										clothing.color, clothing.type, clothing.supplierID,
										clothing.price, clothing.brand, bottom.waistsize, bottom.length, inventory.stock
										from ((clothing
										inner join bottom on clothing.barcode = bottom.barcode)
										inner join inventory on clothing.barcode = inventory.barcode)");
			?>
			<h6>Bottoms list</h6>
			<?php
			/*printResult($result);*/
			/* next two lines from Raghav replace previous line */
			$columnNames = array("Barcode", "Name", "Materials", "Color", "Type", "Supplier ID", "Price ($)", "Brand", "Waist", "Length", "Stock");
			printTable($bottoms, $columnNames);

			$tops = executePlainSQL("select clothing.barcode, clothing.name, clothing.materials,
								clothing.color, clothing.type, clothing.supplierID,
								clothing.price, clothing.brand, top.sizing, inventory.stock
								from ((clothing
								inner join top on clothing.barcode = top.barcode)
								inner join inventory on clothing.barcode = inventory.barcode)");
			?>
			<h6>Tops list</h6>
			<?php
			/*printResult($result);*/
			/* next two lines from Raghav replace previous line */
			$columnNames = array("Barcode", "Name", "Materials", "Color", "Type", "Supplier ID", "Price ($)", "Brand", "Size", "Stock");
			printTable($tops, $columnNames);

			$totalClothing = executePlainSQL("select count(barcode) from clothing");
			/*printResult($result);*/
			/* next two lines from Raghav replace previous line */
			$total = array("Total Number of Clothings");
			?>
			<br>
			<?php
			printTable($totalClothing, $total);
			$popularClothing = executePlainSQL("select c.name, c.barcode, SUM(moo.amount)
												from clothing c, memberorderonline moo
												where not exists
												(select * from member m where not exists
												(select moo.barcode
												from memberorderonline moo
												where moo.memberid = m.id
												and moo.barcode = c.barcode))
												group by c.barcode, c.name");
			$popular = array("Barcode", "Name", "Amount of Items");
			?>
			<br>
			<h6>All Clothing Bought by Every Member</h6>
			<?php
			printTable($popularClothing, $popular);
		}

		//Commit to save changes...
		OCILogoff($db_conn);
	} else {
		echo "cannot connect";
		$e = OCI_Error(); // For OCILogon errors pass no handle
		echo htmlentities($e['message']);
	}
	?>
	<br>
	<br>

	<p>Change Clothing Price</p>
	<p>
		<font size="2"> Item Bacrode&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; New Price</font>
	</p>
	<form method="POST" action="CS304M5manager.php">
		<!-- refreshes page when submitted -->

		<p><input type="text" name="updPriceBarcode" size="8"><input type="text" name="newPrice" size="12">
			<input type="submit" value="Update" name="changePrice"></p>
	</form>

	<p>Delete a piece of Clothing</p>
	<p>
		<font size="2"> Item Bacrode&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
	</p>
	<form method="POST" action="CS304M5manager.php">
		<!-- refreshes page when submitted -->

		<p><input type="text" name="delPriceBarcode" size="8">
			<input type="submit" value="Delete" name="delClothing"></p>
	</form>

	<p>Update Stock</p>
	<p>
		<font size="2"> Item Bacrode&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Stock</font>
	</p>
	<form method="POST" action="CS304M5manager.php">
		<!-- refreshes page when submitted -->

		<p><input type="text" name="updStockBarcode" size="8"><input type="text" name="newStock" size="12">
			<input type="submit" value="Update Stock" name="changeStock"></p>
	</form>

	<?php
	$success = True;
	$db_conn = OCILogon(
		"ora_eric1208",
		"a52835212",
		"dbhost.students.cs.ubc.ca:1522/stu"
	);

	// Connect Oracle...
	if ($db_conn) {
		if (array_key_exists('changePrice', $_POST)) {
			// Get values from the user and insert data into 
			// the table.
			$tuple = array(
				":bind1" => $_POST['updPriceBarcode'],
				":bind2" => $_POST['newPrice']
			);
			$alltuples = array(
				$tuple
			);
			executeBoundSQL("update Clothing set price=:bind2 where barcode=:bind1", $alltuples);
			OCICommit($db_conn);
		} else
		if (array_key_exists('delClothing', $_POST)) {
			$tuple = array(
				":bind1" => $_POST['delPriceBarcode']
			);
			$alltuples = array(
				$tuple
			);
			executeBoundSQL("delete from clothing where barcode=:bind1", $alltuples);
			OCICommit($db_conn);
		} else
		if (array_key_exists('changeStock', $_POST)) {
			$tuple = array(
				":bind1" => $_POST['updStockBarcode'],
				":bind2" => $_POST['newStock']
			);
			$alltuples = array(
				$tuple
			);
			executeBoundSQL("update inventory set stock=:bind2 where barcode=:bind1", $alltuples);
			OCICommit($db_conn);
		}
		if ($_POST && $success) {
			//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
			header("location: CS304M5manager.php");
		} else {
			// Select data...
			$result = executePlainSQL("select * from member");
			?>
			<h6>Member list</h6>
			<?php
			/*printResult($result);*/
			/* next two lines from Raghav replace previous line */
			$columnNames = array("ID", "Name", "E-mail", "Address");
			printTable($result, $columnNames);
		}

		//Commit to save changes...
		OCILogoff($db_conn);
	} else {
		echo "cannot connect";
		$e = OCI_Error(); // For OCILogon errors pass no handle
		echo htmlentities($e['message']);
	}
	?>

	<p>Add more members with the text boxes:</p>
	<p>
		<font size="2"> Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;E-mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Address</font>
	</p>
	<form method="POST" action="CS304M5manager.php">
		<!-- refreshes page when submitted -->

		<p><input type="text" name="insMemName" size="6"><input type="text" name="insMemEmail" size="6"><input type="text" name="insMemAddress" size="12">
			<!-- Define two variables to pass values. -->
			<input type="submit" value="insert" name="insertMember"></p>
	</form>


	<?php
	$success = True;
	$db_conn = OCILogon(
		"ora_eric1208",
		"a52835212",
		"dbhost.students.cs.ubc.ca:1522/stu"
	);

	// Connect Oracle...
	if ($db_conn) {
		if (array_key_exists('resetMember', $_POST)) {
			// Drop old table...
			echo "<br> dropping table <br>";
			executePlainSQL("Drop table member");

			// Create new table...
			echo "<br> creating new table <br>";
			executePlainSQL("create table member
		(id integer generated always as identity, name varchar2(30) not null, email varchar2(30), address varchar2(30),
		primary key (id))");
			OCICommit($db_conn);
		} else
		if (array_key_exists('insertMember', $_POST)) {
			// Get values from the user and insert data into 
			// the table.
			$tuple = array(
				":bind1" => $_POST['insMemName'],
				":bind2" => $_POST['insMemEmail'],
				":bind3" => $_POST['insMemAddress']
			);
			$alltuples = array(
				$tuple
			);
			executeBoundSQL("insert into member (name, email, address)
			values (:bind1, :bind2, :bind3)", $alltuples);
			OCICommit($db_conn);
		}
		if ($_POST && $success) {
			//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
			header("location: CS304M5manager.php");
		}

		//Commit to save changes...
		OCILogoff($db_conn);
	} else {
		echo "cannot connect";
		$e = OCI_Error(); // For OCILogon errors pass no handle
		echo htmlentities($e['message']);
	}
	?>

	<br>
	<p>If you wish to reset the members list, press the reset button.
		If this is the first time that you're running this page,
		you MUST use reset.</p>

	<form method="POST" action="CS304M5manager.php">
		<p><input type="submit" value="Reset" name="resetMember"></p>
	</form>

	<br>
	<p>Add promotions using the text boxes:</p>
	<p>
		<font size="2"> Start date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;End date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;Discount</font>
	</p>
	<form method="POST" action="CS304M5manager.php">

		<p><input type="date" name="insProStartDate"><input type="date" name="insProEndDate"><input type="number" min="1" max="99" name="insProDiscount" size="2">
			<input type="submit" value="insert" name="insertPromotion"></p>
	</form>

	<br>
	<p>Update a promotion using the text boxes:</p>
	<p>
		<font size="2"> ID of existing promotion&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Start date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;End date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;Discount</font>
	</p>

	<form method="POST" action="CS304M5manager.php">

		<p><input type="number" name="updProID" min="1"><input type="date" name="updProStartDate" size="2"><input type="date" name="updProEndDate" size="2"><input type="number" min="1" max="99" name="updProDiscount" size="2">
			<input type="submit" value="update" name="updatePromotion"></p>
	</form>

	<?php
	$success = True;
	$db_conn = OCILogon(
		"ora_eric1208",
		"a52835212",
		"dbhost.students.cs.ubc.ca:1522/stu"
	);
	if ($db_conn) {
		if (array_key_exists('resetPromotion', $_POST)) {
			echo "<br> dropping table <br>";
			executePlainSQL("Drop table promotion");

			echo "<br> creating new table <br>";
			executePlainSQL("create table promotion
		(id integer generated always as identity, startdate date not null, enddate date not null, discount integer,
		primary key (id))");
			OCICommit($db_conn);
		} else
		if (array_key_exists('insertPromotion', $_POST)) {
			$tuple = array(
				":bind1" => $_POST['insProStartDate'],
				":bind2" => $_POST['insProEndDate'],
				":bind3" => $_POST['insProDiscount']
			);
			$alltuples = array(
				$tuple
			);
			executeBoundSQL("insert into promotion (startdate, enddate, discount)
			values (to_date(:bind1, 'yyyy-mm-dd'), to_date(:bind2, 'yyyy-mm-dd'), :bind3)", $alltuples);
			OCICommit($db_conn);
		} else
		if (array_key_exists('updatePromotion', $_POST)) {
			$tuple = array(
				":bind0" => $_POST['updProID'],
				":bind1" => $_POST['updProStartDate'],
				":bind2" => $_POST['updProEndDate'],
				":bind3" => $_POST['updProDiscount']
			);
			$alltuples = array(
				$tuple
			);
			executeBoundSQL("update promotion set startdate=to_date(:bind1, 'yyyy-mm-dd'),
			enddate=to_date(:bind2, 'yyyy-mm-dd'), discount=:bind3
			where id=:bind0", $alltuples);
			OCICommit($db_conn);
		}
		if ($_POST && $success) {
			header("location: CS304M5manager.php");
		} else {
			$result = executePlainSQL("select * from promotion");
			?>
			<h6>Promotion list</h6>
			<?php
			$columnNames = array("ID", "Start Date", "End Date", "Discount %");
			printTable($result, $columnNames);
		}
		OCILogoff($db_conn);
	} else {
		echo "cannot connect";
		$e = OCI_Error();
		echo htmlentities($e['message']);
	}
	?>
	<br>
	<p>If you wish to reset the promotions list, press the reset button.
		If this is the first time that you're running this page,
		you MUST use reset.</p>

	<form method="POST" action="CS304M5manager.php">
		<p><input type="submit" value="Reset" name="resetPromotion"></p>
	</form>



	<br>
	<p>Approve a member order</p>
	<p>
		<font size="2"> Order ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Approved?</font>
	</p>

	<form method="POST" action="CS304M5manager.php">

		<p><input type="number" name="updMooID" min="1">
			<input type="number" min="-1" max="1" name="approveMoo" size="2">
			<input type="submit" value="update" name="approveMemberOrderOnline"></p>
	</form>

	<?php
	$success = True;
	$db_conn = OCILogon(
		"ora_eric1208",
		"a52835212",
		"dbhost.students.cs.ubc.ca:1522/stu"
	);

	if ($db_conn) {
		if (array_key_exists('resetMemberOrderOnline', $_POST)) {
			echo "<br> dropping table <br>";
			executePlainSQL("Drop table MemberOrderOnline");

			echo "<br> creating new table <br>";
			executePlainSQL("create table MemberOrderOnline
		(orderid integer generated always as identity, 
		memberid integer not null, barcode integer not null, 
		amount integer not null, orderdate date,
		approved smallint not null,
		primary key (orderid),
		foreign key(barcode) references clothing(id),
		foreign key(memberid) references member(id))");
			OCICommit($db_conn);
		} else
		if (array_key_exists('approveMemberOrderOnline', $_POST)) {
			$tuple = array(
				":bind0" => $_POST['updMooID'],
				":bind1" => $_POST['approveMoo'],
			);
			$alltuples = array(
				$tuple
			);
			executeBoundSQL("update MemberOrderOnline set approved=:bind1
			where orderid=:bind0", $alltuples);
			OCICommit($db_conn);
		}
		if ($_POST && $success) {
			header("location: CS304M5manager.php");
		} else {
			$result = executePlainSQL("select * from MemberOrderOnline");
			?>
			<h6>Member Orders list</h6>
			<?php
			$columnNames = array("Order ID", "Member ID", "Barcode", "Amount of Items", "Order Date", "Approved?");
			printTable($result, $columnNames);
		}
		OCILogoff($db_conn);
	} else {
		echo "cannot connect";
		$e = OCI_Error();
		echo htmlentities($e['message']);
	}
	?>
	<br>
	<p>If you wish to reset the member orders list, press the reset button.
		If this is the first time that you're running this page,
		you MUST use reset.</p>

	<form method="POST" action="CS304M5manager.php">
		<p><input type="submit" value="Reset" name="resetMemberOrderOnline"></p>
	</form>

	<br>
	<p>Approve a Retailer order</p>
	<p>
		<font size="2"> Order ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Approved?</font>
	</p>

	<form method="POST" action="CS304M5manager.php">

		<p><input type="number" name="updRetID" min="1">
			<input type="number" min="-1" max="1" name="approveRet" size="2">
			<input type="submit" value="update" name="approveRetailerOrder"></p>
	</form>
	<?php
	$success = True;
	$db_conn = OCILogon(
		"ora_eric1208",
		"a52835212",
		"dbhost.students.cs.ubc.ca:1522/stu"
	);

	if ($db_conn) {
		if (array_key_exists('resetRetailerOrder', $_POST)) {
			echo "<br> dropping table <br>";
			executePlainSQL("Drop table RetailerOrderFromInventory");

			echo "<br> creating new table <br>";
			executePlainSQL("create table RetailerOrderFromInventory
							(orderid integer generated always as identity, 
							retailerid integer not null, barcode integer not null, 
							amount integer not null, orderdate date, approved smallint not null,
							primary key (orderid),
							foreign key(barcode) references clothing(id),
							foreign key(retailerid) references retailer(id) on delete cascade)");
			OCICommit($db_conn);
		} else
		if (array_key_exists('approveRetailerOrder', $_POST)) {
			$tuple = array(
				":bind0" => $_POST['updRetID'],
				":bind1" => $_POST['approveRet'],
			);
			$alltuples = array(
				$tuple
			);
			executeBoundSQL("update RetailerOrderFromInventory set approved=:bind1
			where orderid=:bind0", $alltuples);
			OCICommit($db_conn);
		}
		if ($_POST && $success) {
			header("location: CS304M5manager.php");
		} else {
			$result = executePlainSQL("select retailerorderfrominventory.orderid, retailerorderfrominventory.retailerID,
										retailerorderfrominventory.barcode, retailerorderfrominventory.amount, retailerorderfrominventory.orderdate,
										retailerorderfrominventory.approved
										from retailerorderfrominventory");
			?>
			<h6>Retailer Orders list</h6>
			<?php
			$columnNames = array("Order ID", "Retailer ID", "Barcode", "Amount of Items", "Order Date", "Approved?");
			printTable($result, $columnNames);
		}
		OCILogoff($db_conn);
	} else {
		echo "cannot connect";
		$e = OCI_Error();
		echo htmlentities($e['message']);
	}
	?>
	<br>
	<p>If you wish to reset the retailer orders list, press the reset button.
		If this is the first time that you're running this page,
		you MUST use reset.</p>

	<form method="POST" action="CS304M5manager.php">
		<p><input type="submit" value="Reset" name="resetRetailerOrder"></p>
	</form>