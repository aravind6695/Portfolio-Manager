<?php
session_start();

if (!isset($_SESSION['username'])) {
	header("location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Portfolio | Home</title>
</head>
<body>
<center>
	<form action="scripts/logout.php">
		<button type="submit" name="logout">Logout</button>
	</form>

	<br>

	<form action="scripts/buy_sell.php" method="post">
		<h1>Buy</h1>

		<h3>Domestic</h3>
		<select name="buy_stock_dow30">
			<option name="aapl"
			<?php if (isset($_SESSION['buy_stock_dow30']) && $_SESSION['buy_stock_dow30'] == "AAPL") echo "selected";
			?>>AAPL</option>
			<option name="msft"
			<?php if (isset($_SESSION['buy_stock_dow30']) && $_SESSION['buy_stock_dow30'] == "MSFT") echo "selected";
			?>>MSFT</option>
			<option name="dis"
			<?php if (isset($_SESSION['buy_stock_dow30']) && $_SESSION['buy_stock_dow30'] == "DIS") echo "selected";
			?>>DIS</option>
			<option name="ibm"
			<?php if (isset($_SESSION['buy_stock_dow30']) && $_SESSION['buy_stock_dow30'] == "IBM") echo "selected";
			?>>IBM</option>
			<option name="nke"
			<?php if (isset($_SESSION['buy_stock_dow30']) && $_SESSION['buy_stock_dow30'] == "NKE") echo "selected";
			?>>NKE</option>
			<option name="pfe"
			<?php if (isset($_SESSION['buy_stock_dow30']) && $_SESSION['buy_stock_dow30'] == "PFE") echo "selected";
			?>>PFE</option>
		</select>
		<input type="number" step="1" min="1" name="buy_shares_dow30" placeholder="Shares"
		<?php if (isset($_SESSION['buy_shares_dow30'])) {echo "value=\"" . $_SESSION['buy_shares_dow30'] . "\"";}?>
		/>
		<input type="number" name="buy_price_dow30" placeholder="Price"
		<?php if (isset($_SESSION['buy_price_dow30'])) {echo "value=\"" . $_SESSION['buy_price_dow30'] . "\"";}?>
		/>

		<h3>Overseas</h3>
		<select name="buy_stock_overseas">
			<option name="axisbank.ns"
			<?php if (isset($_SESSION['buy_stock_overseas']) && $_SESSION['buy_stock_overseas'] == "AXISBANK.NS") echo "selected";
			?>>AXISBANK.NS</option>
			<option name="bhartiartl.ns"
			<?php if (isset($_SESSION['buy_stock_overseas']) && $_SESSION['buy_stock_overseas'] == "BHARTIARTL.NS") echo "selected";
			?>>BHARTIARTL.NS</option>
			<option name="tcl.ns"
			<?php if (isset($_SESSION['buy_stock_overseas']) && $_SESSION['buy_stock_overseas'] == "TCS.NS") echo "selected";
			?>>TCS.NS</option>
			<option name="kotakbank.ns"
			<?php if (isset($_SESSION['buy_stock_overseas']) && $_SESSION['buy_stock_overseas'] == "KOTAKBANK.NS") echo "selected";
			?>>KOTAKBANK.NS</option>
		</select>
		<input type="number" step="1" min="1" name="buy_shares_overseas" placeholder="Shares"
		<?php if (isset($_SESSION['buy_shares_overseas'])) {echo "value=\"" . $_SESSION['buy_shares_overseas'] . "\"";}?>
		/>
		<input type="number" name="buy_price_overseas" placeholder="Price"
		<?php if (isset($_SESSION['buy_price_overseas'])) {echo "value=\"" . $_SESSION['buy_price_overseas'] . "\"";}?>
		/>

		<h1>Sell</h1>
		<select name="sell_stock">
			<option name="aapl"
			<?php if (isset($_SESSION['sell_stock']) && $_SESSION['sell_stock'] == "AAPL") echo "selected";
			?>>AAPL</option>
			<option name="msft"
			<?php if (isset($_SESSION['sell_stock']) && $_SESSION['sell_stock'] == "MSFT") echo "selected";
			?>>MSFT</option>
			<option name="dis"
			<?php if (isset($_SESSION['sell_stock']) && $_SESSION['sell_stock0'] == "DIS") echo "selected";
			?>>DIS</option>
			<option name="ibm"
			<?php if (isset($_SESSION['sell_stock']) && $_SESSION['sell_stock'] == "IBM") echo "selected";
			?>>IBM</option>
			<option name="nke"
			<?php if (isset($_SESSION['sell_stock']) && $_SESSION['sell_stock'] == "NKE") echo "selected";
			?>>NKE</option>
			<option name="pfe"
			<?php if (isset($_SESSION['sell_stock']) && $_SESSION['bsell_stock'] == "PFE") echo "selected";
			?>>PFE</option>
			<option name="axisbank.ns"
			<?php if (isset($_SESSION['sell_stock']) && $_SESSION['sell_stock'] == "AXISBANK.NS") echo "selected";
			?>>AXISBANK.NS</option>
			<option name="bhartiartl.ns"
			<?php if (isset($_SESSION['sell_stock']) && $_SESSION['sell_stock'] == "BHARTIARTL.NS") echo "selected";
			?>>BHARTIARTL.NS</option>
			<option name="tcl.ns"
			<?php if (isset($_SESSION['sell_stock']) && $_SESSION['sell_stock'] == "TCS.NS") echo "selected";
			?>>TCS.NS</option>
			<option name="kotakbank.ns"
			<?php if (isset($_SESSION['sell_stock']) && $_SESSION['sell_stock'] == "KOTAKBANK.NS") echo "selected";
			?>>KOTAKBANK.NS</option>
		</select>
		<button type="submit" name="select">Select</button>
		<input type="number" step="1" min="1" name="sell_shares" placeholder="Shares"
		<?php if (isset($_SESSION['sell_shares'])) {echo "value=\"" . $_SESSION['sell_shares'] . "\"";}?>
		/>
		<input type="number" name="sell_price" placeholder="Price"
		<?php if (isset($_SESSION['sell_price'])) {echo "value=\"" . $_SESSION['sell_price'] . "\"";}?>
		/>

		<br>

		<?php
		if (isset($_SESSION['select'])) {
			require 'scripts/database.php';

			$username = $_SESSION['username'];
			$symbol = $_SESSION['sell_stock'];

			$query = "SELECT * FROM user_stocks WHERE username = '$username' AND symbol = '$symbol'";
			$result = mysqli_query($conn, $query);
			?>

			<br>
			<table>
				<tr>
					<th>Select</th>
					<th>Symbol</th>
					<th>Shares</th>
					<th>Cost Basis</th>
					<th>Category</th>
				</tr>
				<?php
				$count = 0;
				while ($row = mysqli_fetch_assoc($result)) {
					?>
					<tr>
						<td><input type="radio" name="radio" value=<?php echo "radio" . ++ $count; ?> /></td>
						<td><?php echo $row['symbol'] ?></td>
						<td><?php echo $row['shares'] ?></td>
						<td><?php echo $row['cost_basis'] ?></td>
						<td><?php echo $row['category'] ?></td>
					</tr>
					<?php
				}
				$_SESSION['count'] = $count;
				?>
			</table>

			<?php
		}
		?>

		<br>

		<button type="submit" name="add">Add to Portfolio</button>
	</form>

	<br><br>
	<h1>Deposit/Withdraw Cash</h1>

	<form action="scripts/deposit_withdraw.php" method="post">
		<select name="type">
			<option value="deposit">Deposit</option>
			<option value="withdraw">Withdraw</option>
		</select>
		<input type="text" name="amount" placeholder="Amount"/>
		<br><br>
		<button type="submit" name="add">Add to Portfolio</button>
	</form>
</center>
</body>
</html>
