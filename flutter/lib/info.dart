import 'package:flutter/material.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Informasi Pribadi',
      theme: ThemeData(
        primarySwatch: Colors.blue,
      ),
      home: const NavigationWrapper(),
    );
  }
}

class NavigationWrapper extends StatefulWidget {
  const NavigationWrapper({super.key});

  @override
  State<NavigationWrapper> createState() => _NavigationWrapperState();
}

class _NavigationWrapperState extends State<NavigationWrapper> {
  int _currentIndex = 0;

  final List<Widget> _pages = [
    const Center(
      child: Text(
        'Home Page', // Placeholder for Home Page
        style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
      ),
    ),
    const Center(
      child: Text(
        'Pesanan Anda', // Placeholder for Orders Page
        style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
      ),
    ),
    const Center(
      child: Text(
        'Keranjang Belanja', // Placeholder for Cart Page
        style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
      ),
    ),
    const InformasiPribadiPage(),
  ];

  @override
  Widget build(BuildContext context) {
    final double navbarHeight = MediaQuery.of(context).size.height * 0.08 + 25; // Dynamic height for navigation bar

    return Scaffold(
      body: _pages[_currentIndex],
      bottomNavigationBar: SizedBox(
        height: navbarHeight,
        child: BottomNavigationBar(
          type: BottomNavigationBarType.fixed,
          currentIndex: _currentIndex,
          onTap: (index) {
            setState(() {
              _currentIndex = index;
            });
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
                    'assets/icons/home.png',
                    fit: BoxFit.contain,
                    color: _currentIndex == 0 ? Colors.blue : Colors.grey,
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
                    'assets/icons/orders.png',
                    fit: BoxFit.contain,
                    color: _currentIndex == 1 ? Colors.blue : Colors.grey,
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
                    'assets/icons/cart.png',
                    fit: BoxFit.contain,
                    color: _currentIndex == 2 ? Colors.blue : Colors.grey,
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
                    'assets/icons/account.png',
                    fit: BoxFit.contain,
                    color: _currentIndex == 3 ? Colors.blue : Colors.grey,
                  ),
                ),
              ),
              label: '',
            ),
          ],
        ),
      ),
    );
  }
}

class InformasiPribadiPage extends StatefulWidget {
  const InformasiPribadiPage({super.key});

  @override
  State<InformasiPribadiPage> createState() => _InformasiPribadiPageState();
}

class _InformasiPribadiPageState extends State<InformasiPribadiPage> {
  bool isEditing = false;

  // Controllers for editing text fields
  final TextEditingController fullNameController = TextEditingController(text: "Felicia Wijaya");
  final TextEditingController phoneNumberController = TextEditingController(text: "08123456778");
  final TextEditingController emailController = TextEditingController(text: "tes@gmail.com");

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: PreferredSize(
        preferredSize: const Size.fromHeight(140), // Increased height by 20 pixels (now 140)
        child: AppBar(
          backgroundColor: Colors.white,
          elevation: 0,
          flexibleSpace: Padding(
            padding: const EdgeInsets.only(top: 40.0),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center, // Vertically center the content
              children: [
                Center(
                  child: Image.asset(
                    'assets/logo.png', // Replace with your logo asset
                    height: 50,
                  ),
                ),
                const SizedBox(height: 8.0), // Space between logo and text
                const Text(
                  "INFORMASI PRIBADI",
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
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Card(
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12.0),
          ),
          elevation: 4,
          child: Padding(
            padding: const EdgeInsets.all(16.0),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  children: [
                    const Icon(
                      Icons.account_circle,
                      size: 50,
                    ),
                    const SizedBox(width: 16),
                    const Text(
                      'Felicia',
                      style: TextStyle(
                        fontSize: 20,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                    const Spacer(),
                    IconButton(
                      icon: Icon(isEditing ? Icons.close : Icons.edit),
                      onPressed: () {
                        setState(() {
                          isEditing = !isEditing;
                        });
                      },
                    ),
                  ],
                ),
                const SizedBox(height: 16),
                const Text(
                  'Informasi Pribadi',
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                const SizedBox(height: 8),
                buildTextField('Nama Lengkap', fullNameController, isEditing),
                const SizedBox(height: 8),
                buildTextField('No. telepon', phoneNumberController, isEditing),
                const SizedBox(height: 8),
                buildTextField('Email', emailController, isEditing),
                if (isEditing) ...[
                  const SizedBox(height: 16),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.end,
                    children: [
                      ElevatedButton(
                        onPressed: () {
                          setState(() {
                            isEditing = false;
                          });
                        },
                        style: ElevatedButton.styleFrom(
                          backgroundColor: Colors.grey,
                        ),
                        child: const Text('Batal'),
                      ),
                      const SizedBox(width: 8),
                      ElevatedButton(
                        onPressed: () {
                          setState(() {
                            isEditing = false;
                          });
                        },
                        child: const Text('Simpan'),
                      ),
                    ],
                  ),
                ],
              ],
            ),
          ),
        ),
      ),
    );
  }

 


  Widget buildTextField(String label, TextEditingController controller, bool isEnabled) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          label,
          style: const TextStyle(fontSize: 14, color: Colors.grey),
        ),
        const SizedBox(height: 4),
        TextField(
          controller: controller,
          enabled: isEnabled,
          decoration: InputDecoration(
            border: OutlineInputBorder(
              borderRadius: BorderRadius.circular(8.0),
            ),
            filled: true,
            fillColor: isEnabled ? Colors.white : Colors.grey[200],
          ),
          style: const TextStyle(fontSize: 14),
        ),
      ],
    );
  }
}
