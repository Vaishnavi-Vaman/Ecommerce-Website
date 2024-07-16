<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecom - Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .sidebar {
            width: 200px;
            background-color: #3f51b5;
            padding: 20px;
            color: white;
            height: 100vh;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            margin: 10px 0;
        }
        .content {
            padding: 20px;
            flex-grow: 1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .search-box {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Ecom - Admin</h2>
        <a href="#">Home</a>
        <a href="#">Category</a>
        <a href="#">Products</a>
        <a href="#">Users</a>
        <a href="#">Orders</a>
        <a href="#">Change Password</a>
        <a href="#">Logout</a>
    </div>
    <div class="content">
        <h1>Manage Orders</h1>
        <div class="search-box">
            <input type="text" placeholder="Search...">
        </div>
        <table>
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Order No</th>
                    <th>User Name</th>
                    <th>User Phone</th>
                    <th>Payment Status</th>
                    <th>Order Status</th>
                    <th>Order Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>#170711117465C07306D822B</td>
                    <td>Abhilash</td>
                    <td>8904653322</td>
                    <td>Success</td>
                    <td>Order Shipped</td>
                    <td>05 Feb, 2024 11.02 am</td>
                    <td>
                        <a href="#">👁️</a> | <a href="#">🚚</a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>#170754802265C71D76D908D</td>
                    <td>Abhilash</td>
                    <td>8904653322</td>
                    <td>Success</td>
                    <td>Order Delivered</td>
                    <td>10 Feb, 2024 12.23 pm</td>
                    <td>
                        <a href="#">👁️</a> | <a href="#">🚚</a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>#170858353165D6EA6B2AAC7</td>
                    <td>Abhilash</td>
                    <td>8904653322</td>
                    <td>Success</td>
                    <td>Order Placed</td>
                    <td>22 Feb, 2024 12.02 pm</td>
                    <td>
                        <a href="#">👁️</a> | <a href="#">🚚</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>#170858388965D6EBD1C1164</td>
                    <td>Abhilash</td>
                    <td>8904653322</td>
                    <td>Success</td>
                    <td>Order Placed</td>
                    <td>22 Feb, 2024 12.08 pm</td>
                    <td>
                        <a href="#">👁️</a> | <a href="#">🚚</a>
                    </td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>#171047733365F3D015EB4AF</td>
                    <td>Abhilash</td>
                    <td>8904653322</td>
                    <td>Success</td>
                    <td>Order Placed</td>
                    <td>15 Mar, 2024 10.05 am</td>
                    <td>
                        <a href="#">👁️</a> | <a href="#">🚚</a>
                    </td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>#171074605365F7E9C56FEFB</td>
                    <td>Abhilash</td>
                    <td>8904653322</td>
                    <td>Success</td>
                    <td>Order Placed</td>
                    <td>18 Mar, 2024 12.44 pm</td>
                    <td>
                        <a href="#">👁️</a> | <a href="#">🚚</a>
                    </td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>#171799653866668BFA5DB49</td>
                    <td>Abhilash</td>
                    <td>8904653322</td>
                    <td>Success</td>
                    <td>Order Placed</td>
                    <td>10 Jun, 2024 10.45 am</td>
                    <td>
                        <a href="#">👁️</a> | <a href="#">🚚</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
        