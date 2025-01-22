import 'package:apk/dashboard_screen.dart';
import 'package:flutter/material.dart';
import 'lanjutbelanja.dart';
import 'navbar.dart';
import 'pesanan_screen.dart';
import 'menu_screen.dart';

class KeranjangScreen extends StatefulWidget {
  @override
  _KeranjangScreenState createState() => _KeranjangScreenState();
}

class _KeranjangScreenState extends State<KeranjangScreen> {
  int _currentIndex = 2; // Indeks halaman yang sedang aktif

  // Daftar halaman yang akan dipilih berdasarkan indeks
  final List<Widget> _screens = [
    DashboardScreen(),
    PesananScreen(),
    KeranjangScreen(),
    MenuScreen(),
  ];

  @override
  void initState() {
    super.initState();
  }

  void _onItemTapped(int index) {
    setState(() {
      _currentIndex = index;
    });
  }

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
        builder: (context) => DashboardScreen(),
      ),
    );
  }

  void showItemDetail(CartItem item) {
    showDialog(
      context: context,
      barrierDismissible: true,
      builder: (context) {
        return Dialog(
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(20),
          ),
          child: Container(
            width: double.infinity,
            height: MediaQuery.of(context).size.height * 0.5,
            padding: EdgeInsets.all(16),
            child: Column(
              children: [
                Image.asset(item.imageUrl,
                    width: 100, height: 100, fit: BoxFit.cover),
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
                    Navigator.pop(context);
                  },
                  child: Text("Close"),
                  style: ElevatedButton.styleFrom(
                    backgroundColor: Colors.blue,
                    padding: EdgeInsets.symmetric(vertical: 16),
                    shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(12)),
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
        preferredSize: Size.fromHeight(140),
        child: AppBar(
          backgroundColor: Colors.white,
          surfaceTintColor: Colors.white, // Important for Material 3

          elevation: 0,
          flexibleSpace: Padding(
            padding: const EdgeInsets.only(top: 10.0),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Center(
                  child: Image.asset(
                    'assets/logo.png',
                    height: 50,
                  ),
                ),
                SizedBox(height: 8.0),
                Text(
                  "KERANJANG",
                  style: TextStyle(
                    fontSize: 24,
                    fontWeight: FontWeight.bold,
                    color: Colors.black,
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
      body: Column(
        children: [
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16.0)
                .copyWith(top: 16.0),
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
                  return HoverableCard(
                    onTap: navigateToShop,
                  );
                }
              },
            ),
          ),
          Padding(
            padding: const EdgeInsets.all(16.0),
            child: Align(
              alignment: Alignment.centerRight,
              child: FractionallySizedBox(
                alignment: Alignment.center,
                widthFactor: 1 / 3,
                child: ElevatedButton(
                  onPressed: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) =>
                            LanjutBayarPage(), // Navigate to LanjutBayarPage
                      ),
                    );
                  },
                  child: Text(
                    "Checkout",
                    style: TextStyle(
                        fontWeight: FontWeight.bold, color: Colors.white),
                  ),
                  style: ElevatedButton.styleFrom(
                    backgroundColor: Colors.blue,
                    padding: EdgeInsets.symmetric(vertical: 16),
                    shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(12)),
                    minimumSize: Size(double.infinity, 50),
                  ),
                ),
              ),
            ),
          ),
        ],
      ),
      bottomNavigationBar: Navbar(
        currentIndex: _currentIndex,
        onTap: _onItemTapped,
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
                  Image.asset(widget.cartItem.imageUrl,
                      width: 80, height: 80, fit: BoxFit.cover),
                  SizedBox(width: 16),
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                            "${widget.cartItem.itemNumber}. ${widget.cartItem.title}",
                            style: TextStyle(fontWeight: FontWeight.bold)),
                        Text(widget.cartItem.subtitle),
                        Text(widget.cartItem.quantity,
                            style: TextStyle(color: Colors.grey)),
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
                      Text(widget.cartItem.price,
                          style: TextStyle(fontWeight: FontWeight.bold)),
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
          elevation: 6,
          shape:
              RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
          color: Colors.blue,
          child: Container(
            padding: EdgeInsets.symmetric(vertical: 16),
            child: Center(
              child: Text(
                "Lanjut Belanja",
                style:
                    TextStyle(color: Colors.white, fontWeight: FontWeight.bold),
              ),
            ),
          ),
        ),
      ),
    );
  }
}

class QuantityOption extends StatelessWidget {
  final String quantity;
  final String price;

  const QuantityOption({required this.quantity, required this.price});

  @override
  Widget build(BuildContext context) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        Text(quantity),
        Text(price, style: TextStyle(fontWeight: FontWeight.bold)),
      ],
    );
  }
}
