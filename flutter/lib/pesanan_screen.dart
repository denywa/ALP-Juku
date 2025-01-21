import 'package:flutter/material.dart';
import 'lanjutbelanja.dart';
import 'navbar.dart';
import 'pesanan_screen.dart';
import 'menu_screen.dart';
import 'dashboard_screen.dart';
import 'keranjang_screen.dart';

class CartItem {
  final String imageUrl;
  final String title;
  final String subtitle;
  final String price;

  CartItem({
    required this.imageUrl,
    required this.title,
    required this.subtitle,
    required this.price,
  });
}

class PesananScreen extends StatefulWidget {
  @override
  _PesananScreenState createState() => _PesananScreenState();
}

class _PesananScreenState extends State<PesananScreen> {
  int _currentIndex = 1; // Indeks halaman yang sedang aktif

  // Daftar halaman yang akan dipilih berdasarkan indeks
  final List<Widget> _screens = [
    DashboardScreen(),
    PesananScreen(),
    KeranjangScreen(),
    MenuScreen(),
  ];

  void _onItemTapped(int index) {
    if (index != _currentIndex) {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (context) => _screens[index]),
      );
    }
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
            height: MediaQuery.of(context).size.height * 0.7,
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
                    Navigator.pop(context);
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
        preferredSize: Size.fromHeight(140),
        child: AppBar(
          backgroundColor: Colors.white,
          elevation: 0,
          flexibleSpace: Padding(
            padding: const EdgeInsets.only(top: 40.0),
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
                  "PESANAN",
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
      body: ListView.builder(
        padding: EdgeInsets.all(16),
        itemCount: 3,
        itemBuilder: (context, index) {
          final item = CartItem(
            imageUrl: 'assets/nilahitam.png',
            title: 'Nila Hitam',
            subtitle: 'Tambak Ikan A',
            price: index == 0
                ? 'Rp42.000'
                : index == 1
                    ? 'Rp84.000'
                    : 'Rp21.000',
          );
          return SizedBox(
            height: 160,
            child: Card(
              elevation: 4,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(12),
              ),
              child: InkWell(
                onTap: () => showItemDetail(item),
                child: Padding(
                  padding: const EdgeInsets.all(16),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          Text(
                            '18 Jan 2024',
                            style: TextStyle(color: Colors.grey),
                          ),
                          Column(
                            crossAxisAlignment: CrossAxisAlignment.center,
                            children: [
                              Container(
                                padding: EdgeInsets.symmetric(horizontal: 12, vertical: 4),
                                decoration: BoxDecoration(
                                  color: index == 0
                                      ? Colors.blue[100]
                                      : index == 1
                                          ? Colors.orange[100]
                                          : Colors.green[100],
                                  borderRadius: BorderRadius.circular(12),
                                ),
                                child: Text(
                                  index == 0
                                      ? 'Dalam Pengiriman'
                                      : index == 1
                                          ? 'Sedang Dikemas'
                                          : 'Sudah di Destinasi',
                                  style: TextStyle(fontWeight: FontWeight.bold),
                                ),
                              ),
                            ],
                          ),
                        ],
                      ),
                      SizedBox(height: 8),
                      Row(
                        children: [
                          Image.asset(
                            'assets/nilahitam.png',
                            height: 64,
                            width: 64,
                          ),
                          SizedBox(width: 16),
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Text(
                                  item.title,
                                  style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                                ),
                                SizedBox(height: 4),
                                Text(item.subtitle),
                                SizedBox(height: 4),
                                Text(index == 0
                                    ? '2 pc'
                                    : index == 1
                                        ? '4 pc'
                                        : '1 pc'),
                              ],
                            ),
                          ),
                          Text(
                            item.price,
                            style: TextStyle(fontWeight: FontWeight.bold, fontSize: 16),
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
              ),
            ),
          );
        },
      ),
      bottomNavigationBar: Navbar(
        currentIndex: _currentIndex,
        onTap: _onItemTapped,
      ),
    );
  }
}

class QuantityOption extends StatelessWidget {
  final String quantity;
  final String price;

  QuantityOption({required this.quantity, required this.price});

  @override
  Widget build(BuildContext context) {
    return ListTile(
      title: Text(quantity),
      trailing: Text(price),
    );
  }
}
