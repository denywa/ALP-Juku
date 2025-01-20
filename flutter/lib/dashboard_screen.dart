import 'package:flutter/material.dart';
import 'detail_screen.dart'; // Pastikan file detail_screen.dart ada
import 'menu_screen.dart';
import 'navbar.dart'; // Pastikan ini adalah file yang mendefinisikan Navbar di main.dart

class DashboardScreen extends StatefulWidget {
  const DashboardScreen({super.key});

  @override
  State<DashboardScreen> createState() => _DashboardScreenState();
}

class _DashboardScreenState extends State<DashboardScreen> {
  int _currentIndex = 0;

  // Daftar halaman untuk navigasi
  final List<Widget> _pages = [
    // Halaman Beranda
    ListView(
      padding: const EdgeInsets.all(16.0),
      children: [
        TextField(
          decoration: InputDecoration(
            hintText: 'Cari ikan...',
            prefixIcon: const Icon(Icons.search),
            border: OutlineInputBorder(
              borderRadius: BorderRadius.circular(8.0),
            ),
          ),
        ),
        const SizedBox(height: 20),
        Container(
          height: 150,
          decoration: BoxDecoration(
            color: Colors.blue.shade100,
            borderRadius: BorderRadius.circular(8.0),
          ),
          child: const Center(
            child: Text(
              'Promo! Diskon 50% untuk semua ikan Bolu!',
              style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
              textAlign: TextAlign.center,
            ),
          ),
        ),
        const SizedBox(height: 20),
        const Text(
          'Ikan',
          style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
        ),
        const SizedBox(height: 10),
        GridView.builder(
          shrinkWrap: true,
          physics: const NeverScrollableScrollPhysics(),
          gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
            crossAxisCount: 2,
            crossAxisSpacing: 10,
            mainAxisSpacing: 10,
            childAspectRatio: 2 / 3,
          ),
          itemCount: 4,
          itemBuilder: (context, index) {
            return GestureDetector(
              onTap: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(
                    builder: (context) => DetailScreen(
                      productName: 'Ikan Nila',
                      productPrice: 'Rp20.000 - Rp60.000',
                      productImage: 'assets/sample_fish.png',
                      productDescription:
                          'Ikan Nila segar, cocok untuk masakan sehari-hari. Berat 1-2 kg.',
                    ),
                  ),
                );
              },
              child: Card(
                elevation: 2,
                child: Column(
                  children: [
                    Expanded(
                      child: Image.asset(
                        'assets/sample_fish.png',
                        fit: BoxFit.cover,
                      ),
                    ),
                    const SizedBox(height: 8),
                    const Text(
                      'Ikan Nila',
                      style: TextStyle(fontWeight: FontWeight.bold),
                    ),
                    const Text('Rp20.000 - Rp60.000'),
                  ],
                ),
              ),
            );
          },
        ),
      ],
    ),
    Column(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        Image.asset('assets/icons/orders.png', height: 100),
        const SizedBox(height: 10),
        const Text(
          'Pesanan Anda',
          style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
        ),
      ],
    ),
    Column(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        Image.asset('assets/icons/cart.png', height: 100),
        const SizedBox(height: 10),
        const Text(
          'Keranjang Belanja',
          style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
        ),
      ],
    ),
    Column(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        Image.asset('assets/icons/account.png', height: 100),
        const SizedBox(height: 10),
        const Text(
          'Akun Saya',
          style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
        ),
      ],
    ),
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Dashboard'),
        backgroundColor: Colors.blue,
      ),
      body: _pages[_currentIndex],
      bottomNavigationBar: Navbar(
        currentIndex: _currentIndex,
        onTap: (index) {
          setState(() {
            _currentIndex = index;
          });
        },
      ),
    );
  }
}
