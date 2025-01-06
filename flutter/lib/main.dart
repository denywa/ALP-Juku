import 'package:flutter/material.dart';

void main() => runApp(CartApp());

class CartApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: ShoppingCartScreen(),
      theme: ThemeData.light(),
    );
  }
}

class ShoppingCartScreen extends StatefulWidget {
  @override
  _ShoppingCartScreenState createState() => _ShoppingCartScreenState();
}

class _ShoppingCartScreenState extends State<ShoppingCartScreen> {
  List<CartItem> cartItems = [
    CartItem(
      itemNumber: 1,
      imageUrl: 'assets/nilahitam.png',
      title: "Nila hitam",
      subtitle: "Tambak Ikan A",
      quantity: "2 pc",
      price: "Rp42.000",
    ),
    CartItem(
      itemNumber: 2,
      imageUrl: 'assets/nilahitam.png',
      title: "Nila hitam",
      subtitle: "Tambak Ikan A",
      quantity: "2 pc",
      price: "Rp42.000",
    ),
  ];

  bool isAllSelected = false;

  void toggleSelectAll(bool? value) {
    setState(() {
      isAllSelected = value ?? false;
      for (var item in cartItems) {
        item.isSelected = isAllSelected;
      }
    });
  }

  void removeItem(CartItem item) {
    setState(() {
      cartItems.remove(item);
    });
  }

  void navigateToShop() {
    Navigator.push(
      context,
      MaterialPageRoute(
        builder: (context) => LanjutBelanjaPage(),
      ),
    );
  }

  void showItemDetail(CartItem item) {
    showDialog(
      context: context,
      barrierDismissible: true, // Allows dismissing by tapping outside
      builder: (context) {
        return Dialog(
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(20),
          ),
          child: Container(
            width: double.infinity,
            height: MediaQuery.of(context).size.height * 0.5, // Half the screen height
            padding: EdgeInsets.all(16),
            child: Column(
              children: [
                Image.asset(item.imageUrl, width: 100, height: 100, fit: BoxFit.cover),
                SizedBox(height: 16),
                Text(
                  item.title,
                  style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
                ),
                Text(item.subtitle),
                SizedBox(height: 16),
                Expanded(
                  child: ListView(
                    children: [
                      QuantityOption(quantity: "6 kg", price: "Rp20.000"),
                      QuantityOption(quantity: "10 kg", price: "Rp22.000"),
                    ],
                  ),
                ),
                SizedBox(height: 16),
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Text(
                      "Total harga",
                      style: TextStyle(fontWeight: FontWeight.bold),
                    ),
                    Text(item.price),
                  ],
                ),
                SizedBox(height: 16),
                ElevatedButton(
                  onPressed: () {
                    Navigator.pop(context); // Close the dialog
                  },
                  child: Text("Close"),
                  style: ElevatedButton.styleFrom(
                    backgroundColor: Colors.blue,
                    padding: EdgeInsets.symmetric(vertical: 16),
                    shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                    minimumSize: Size(double.infinity, 50),
                  ),
                ),
              ],
            ),
          ),
        );
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: PreferredSize(
        preferredSize: Size.fromHeight(100),
        child: AppBar(
          backgroundColor: Colors.white,
          elevation: 0,
          flexibleSpace: Padding(
            padding: const EdgeInsets.only(top: 40.0),
            child: Center(
              child: Image.asset(
                'assets/logo.png', // Replace with your logo asset
                height: 50,
              ),
            ),
          ),
        ),
      ),
      body: Column(
        children: [
          // "KERANJANG" Title
          Padding(
            padding: const EdgeInsets.only(top: 16.0),
            child: Text(
              "KERANJANG",
              style: TextStyle(
                fontSize: 24,
                fontWeight: FontWeight.bold,
                color: Colors.black,
              ),
            ),
          ),
          // "Pilih Semua" Checkbox
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16.0),
            child: Row(
              children: [
                Checkbox(
                  value: isAllSelected,
                  onChanged: toggleSelectAll,
                ),
                Text(
                  "Pilih semua",
                  style: TextStyle(fontSize: 16),
                ),
              ],
            ),
          ),
          // Cart Items
          Expanded(
            child: ListView.builder(
              padding: const EdgeInsets.all(16.0),
              itemCount: cartItems.length + 1,
              itemBuilder: (context, index) {
                if (index < cartItems.length) {
                  return StatefulCartItem(
                    cartItem: cartItems[index],
                    onRemove: () => removeItem(cartItems[index]),
                    onDetail: () => showItemDetail(cartItems[index]),
                  );
                } else {
                  // "Lanjut Belanja" Button
                  return HoverableCard(
                    onTap: navigateToShop,
                  );
                }
              },
            ),
          ),
          // "Checkout" Button
          Padding(
            padding: const EdgeInsets.all(16.0),
            child: ElevatedButton(
              onPressed: () {},
              child: Text("Checkout"),
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.blue,
                padding: EdgeInsets.symmetric(vertical: 16),
                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                minimumSize: Size(double.infinity, 50),
              ),
            ),
          ),
        ],
      ),
      bottomNavigationBar: BottomNavigationBar(
        currentIndex: 2,
        items: [
          BottomNavigationBarItem(icon: Icon(Icons.home), label: "Beranda"),
          BottomNavigationBarItem(icon: Icon(Icons.receipt), label: "Pesanan"),
          BottomNavigationBarItem(icon: Icon(Icons.shopping_cart), label: "Keranjang"),
          BottomNavigationBarItem(icon: Icon(Icons.person), label: "Akun"),
        ],
        selectedItemColor: Colors.blue,
        unselectedItemColor: Colors.grey,
      ),
    );
  }
}

class QuantityOption extends StatelessWidget {
  final String quantity;
  final String price;

  const QuantityOption({
    required this.quantity,
    required this.price,
  });

  @override
  Widget build(BuildContext context) {
    return ListTile(
      title: Text(quantity),
      subtitle: Text(price),
      leading: Icon(Icons.add_circle_outline),
    );
  }
}

class StatefulCartItem extends StatefulWidget {
  final CartItem cartItem;
  final VoidCallback onRemove;
  final VoidCallback onDetail;

  const StatefulCartItem({
    required this.cartItem,
    required this.onRemove,
    required this.onDetail,
  });

  @override
  _StatefulCartItemState createState() => _StatefulCartItemState();
}

class _StatefulCartItemState extends State<StatefulCartItem> {
  @override
  Widget build(BuildContext context) {
    return Card(
      elevation: 4,
      margin: EdgeInsets.only(bottom: 16),
      child: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Row(
          children: [
            Checkbox(
              value: widget.cartItem.isSelected,
              onChanged: (value) {
                setState(() {
                  widget.cartItem.isSelected = value ?? false;
                });
              },
            ),
            Expanded(
              child: Row(
                children: [
                  Image.asset(widget.cartItem.imageUrl, width: 80, height: 80, fit: BoxFit.cover),
                  SizedBox(width: 16),
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text("${widget.cartItem.itemNumber}. ${widget.cartItem.title}",
                            style: TextStyle(fontWeight: FontWeight.bold)),
                        Text(widget.cartItem.subtitle),
                        Text(widget.cartItem.quantity, style: TextStyle(color: Colors.grey)),
                      ],
                    ),
                  ),
                  Column(
                    crossAxisAlignment: CrossAxisAlignment.end,
                    children: [
                      PopupMenuButton<String>(
                        onSelected: (value) {
                          if (value == "Hapus") {
                            widget.onRemove();
                          } else if (value == "Detail") {
                            widget.onDetail();
                          }
                        },
                        itemBuilder: (context) => [
                          PopupMenuItem(value: "Hapus", child: Text("Hapus")),
                          PopupMenuItem(value: "Detail", child: Text("Detail")),
                        ],
                      ),
                      SizedBox(height: 8),
                      Text(widget.cartItem.price, style: TextStyle(fontWeight: FontWeight.bold)),
                    ],
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class CartItem {
  final int itemNumber;
  final String imageUrl;
  final String title;
  final String subtitle;
  final String quantity;
  final String price;
  bool isSelected;

  CartItem({
    required this.itemNumber,
    required this.imageUrl,
    required this.title,
    required this.subtitle,
    required this.quantity,
    required this.price,
    this.isSelected = false,
  });
}

class HoverableCard extends StatefulWidget {
  final VoidCallback onTap;

  const HoverableCard({required this.onTap});

  @override
  _HoverableCardState createState() => _HoverableCardState();
}

class _HoverableCardState extends State<HoverableCard> {
  bool isHovered = false;

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: widget.onTap,
      child: MouseRegion(
        onEnter: (_) => setState(() => isHovered = true),
        onExit: (_) => setState(() => isHovered = false),
        child: Card(
          elevation: isHovered ? 8 : 4,
          color: isHovered ? Colors.blue[100] : Colors.white,
          child: Padding(
            padding: const EdgeInsets.all(16.0),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Icon(Icons.add, size: 36, color: Colors.black),
                SizedBox(height: 8),
                Text(
                  "Lanjut belanja",
                  style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}


class LanjutBelanjaPage extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Lanjut Belanja")),
      body: Center(child: Text("You can continue shopping here.")),
    );
  }
}
