import 'package:flutter/material.dart';
import 'package:apk/menu_screen.dart'
    as menu_screen; // Menggunakan alias untuk menu_screen
import 'package:apk/pesanan_screen.dart'
    as pesanan_screen; // Menggunakan alias untuk pesanan_screen
import 'package:apk/keranjang_screen.dart'
    as keranjang_screen; // Menggunakan alias untuk keranjang_screen
import 'package:apk/dashboard_screen.dart'; // Mengimpor DashboardScreen tanpa alias
import 'package:apk/service/auth_service.dart'; // Import AuthService
import 'login_screen.dart'; // Mengimpor LoginScreen tanpa alias

class Navbar extends StatelessWidget {
  final int currentIndex;
  final ValueChanged<int> onTap;

  const Navbar({Key? key, required this.currentIndex, required this.onTap})
      : super(key: key);

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
                'assets/icons/home.png', // Ganti dengan ikon yang sesuai
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
                'assets/icons/orders.png', // Ganti dengan ikon yang sesuai
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
                'assets/icons/cart.png', // Ganti dengan ikon yang sesuai
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
                'assets/icons/menu.png', // Ganti dengan ikon yang sesuai
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

  void _navigateToScreen(BuildContext context, int index) async {
    final authService = AuthService(); // Instance dari AuthService
    switch (index) {
      case 0:
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(builder: (context) => DashboardScreen()),
        );
        break;
      case 1:
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(
              builder: (context) => pesanan_screen.PesananScreen()),
        );
        break;
      case 2:
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(
              builder: (context) => keranjang_screen.KeranjangScreen()),
        );
        break;
      case 3:
        // Cek apakah pengguna sudah login
        bool isLoggedIn = await authService.isLoggedIn();
        if (isLoggedIn) {
          Navigator.pushReplacement(
            context,
            MaterialPageRoute(builder: (context) => menu_screen.MenuScreen()),
          );
        } else {
          // Jika belum login, arahkan ke halaman login
          Navigator.pushReplacement(
            context,
            MaterialPageRoute(builder: (context) => LoginScreen()),
          );
        }
        break;
      default:
        break;
    }
  }
}
