import 'package:flutter/material.dart';
import 'lanjutbelanja.dart';
import 'navbar.dart';
import 'menu_screen.dart';
import 'dashboard_screen.dart';
import 'keranjang_screen.dart';
import 'detail_pesanan.dart';

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

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: PreferredSize(
        preferredSize: const Size.fromHeight(60),
        child: AppBar(
          backgroundColor: Colors.white,
          surfaceTintColor: Colors.white,
          elevation: 0,
          flexibleSpace: Padding(
            padding: const EdgeInsets.only(
                top: 10.0, left: 16.0, right: 16.0), // Added left padding
            child: Row(
              mainAxisAlignment: MainAxisAlignment
                  .spaceBetween, // Align items to space between
              children: [
                const Padding(
                  padding: EdgeInsets.only(right: 16.0),
                  child: Text(
                    'PESANAN',
                    style: TextStyle(
                      fontSize: 20,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                ),
                const SizedBox(width: 16), // Add space between text and logo
                Center(
                  // Center the logo vertically
                  child: Image.asset(
                    'assets/logo.png',
                    height: 50,
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
                onTap: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (context) => DetailPesananPage(item: item),
                    ),
                  );
                },
                child: Padding(
                  padding: const EdgeInsets.all(16),
                  child: Stack(
                    children: [
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Row(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: [
                              Text(
                                '18 Jan 2024',
                                style: TextStyle(
                                    color: const Color.fromARGB(
                                        255, 255, 255, 255)),
                              ),
                              Column(
                                crossAxisAlignment: CrossAxisAlignment.center,
                                children: [
                                  Container(
                                    padding: EdgeInsets.symmetric(
                                        horizontal: 12, vertical: 4),
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
                                      style: TextStyle(
                                          fontWeight: FontWeight.bold),
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
                                      style: TextStyle(
                                          fontSize: 18,
                                          fontWeight: FontWeight.bold),
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
                                style: TextStyle(
                                    fontWeight: FontWeight.bold, fontSize: 16),
                              ),
                            ],
                          ),
                        ],
                      ),
                      Positioned(
                        bottom: 8,
                        right: 8,
                        child: Text(
                          'Estimasi: 10 menit 1 jam',
                          style: TextStyle(
                            fontSize: 12,
                            color: Colors.grey[600],
                          ),
                        ),
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
