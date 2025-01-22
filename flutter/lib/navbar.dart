import 'package:flutter/material.dart';
import 'package:apk/menu_screen.dart' as menu_screen; // Menggunakan alias untuk menu_screen
import 'package:apk/pesanan_screen.dart' as pesanan_screen; // Menggunakan alias untuk pesanan_screen
import 'package:apk/keranjang_screen.dart' as keranjang_screen; // Menggunakan alias untuk keranjang_screen
import 'package:apk/dashboard_screen.dart'; // Mengimpor DashboardScreen tanpa alias

class Navbar extends StatelessWidget {
  final int currentIndex;
  final ValueChanged<int> onTap;

  const Navbar({Key? key, required this.currentIndex, required this.onTap}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final double navbarHeight = MediaQuery.of(context).size.height * 0.08 + 25;

    return BottomNavigationBar(
      type: BottomNavigationBarType.fixed,
      currentIndex: currentIndex,
      onTap: (index) {
        onTap(index);
        _navigateToScreen(context, index); // Navigasi sesuai dengan index
      },
      showSelectedLabels: false,
      showUnselectedLabels: false,
      items: [
        BottomNavigationBarItem(
          icon: Padding(
            padding: const EdgeInsets.only(bottom: 4.0),
            child: SizedBox(
              height: navbarHeight * 0.6,
              child: Image.asset(
                'assets/icons/home.png',  // Ganti dengan ikon yang sesuai
                fit: BoxFit.contain,
                color: currentIndex == 0 ? Colors.blue : Colors.grey,
              ),
            ),
          ),
          label: '',
        ),
        BottomNavigationBarItem(
          icon: Padding(
            padding: const EdgeInsets.only(bottom: 4.0),
            child: SizedBox(
              height: navbarHeight * 0.6,
              child: Image.asset(
                'assets/icons/orders.png',  // Ganti dengan ikon yang sesuai
                fit: BoxFit.contain,
                color: currentIndex == 1 ? Colors.blue : Colors.grey,
              ),
            ),
          ),
          label: '',
        ),
        BottomNavigationBarItem(
          icon: Padding(
            padding: const EdgeInsets.only(bottom: 4.0),
            child: SizedBox(
              height: navbarHeight * 0.6,
              child: Image.asset(
                'assets/icons/cart.png',  // Ganti dengan ikon yang sesuai
                fit: BoxFit.contain,
                color: currentIndex == 2 ? Colors.blue : Colors.grey,
              ),
            ),
          ),
          label: '',
        ),
        BottomNavigationBarItem(
          icon: Padding(
            padding: const EdgeInsets.only(bottom: 4.0),
            child: SizedBox(
              height: navbarHeight * 0.6,
              child: Image.asset(
                'assets/icons/menu.png',  // Ganti dengan ikon yang sesuai
                fit: BoxFit.contain,
                color: currentIndex == 3 ? Colors.blue : Colors.grey,
              ),
            ),
          ),
          label: '',
        ),
      ],
    );
  }

  void _navigateToScreen(BuildContext context, int index) {
    switch (index) {
      case 0:
        Navigator.pushAndRemoveUntil(
          context,
          MaterialPageRoute(builder: (context) => DashboardScreen()),
          (route) => false, // Menghapus semua route sebelumnya
        );
        break;
      case 1:
        Navigator.pushAndRemoveUntil(
          context,
          MaterialPageRoute(builder: (context) => pesanan_screen.PesananScreen()),
          (route) => false, // Menghapus semua route sebelumnya
        );
        break;
      case 2:
        Navigator.pushAndRemoveUntil(
          context,
          MaterialPageRoute(builder: (context) => keranjang_screen.KeranjangScreen()),
          (route) => false, // Menghapus semua route sebelumnya
        );
        break;
      case 3:
        Navigator.pushAndRemoveUntil(
          context,
          MaterialPageRoute(builder: (context) => menu_screen.MenuScreen()),
          (route) => false, // Menghapus semua route sebelumnya
        );
        break;
      default:
        break;
    }
  }
}
