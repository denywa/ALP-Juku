import 'package:flutter/material.dart';

class DetailScreen extends StatelessWidget {
  final String productName;
  final String productPrice;
  final String productImage;
  final String productDescription;

  const DetailScreen({
    super.key,
    required this.productName,
    required this.productPrice,
    required this.productImage,
    required this.productDescription,
  });

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(productName),
      ),
      body: Stack(
        children: [
          ListView(
            padding: const EdgeInsets.all(16.0),
            children: [
              // Product Image and Price
              Card(
                elevation: 2,
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Image.asset(
                      productImage,
                      fit: BoxFit.cover,
                      height: 200,
                      width: double.infinity,
                    ),
                    Padding(
                      padding: const EdgeInsets.all(8.0),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            productName,
                            style: const TextStyle(
                              fontSize: 20,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                          const SizedBox(height: 8),
                          Text(
                            productPrice,
                            style: const TextStyle(
                              fontSize: 16,
                              color: Color.fromARGB(255, 2, 202, 224),
                            ),
                          ),
                        ],
                      ),
                    ),
                  ],
                ),
              ),
              const SizedBox(height: 20),

              // Product Description
              Card(
                elevation: 2,
                child: Padding(
                  padding: const EdgeInsets.all(16.0),
                  child: Text(
                    productDescription,
                    style: const TextStyle(fontSize: 16),
                  ),
                ),
              ),
              const SizedBox(height: 20),

              // Product Rating
              Card(
                elevation: 2,
                child: Padding(
                  padding: const EdgeInsets.all(16.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      const Text(
                        'Penilaian Produk',
                        style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                      ),
                      const SizedBox(height: 16),
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                        children: List.generate(5, (index) {
                          return const Icon(
                            Icons.star_border,
                            size: 32,
                            color: Colors.grey,
                          );
                        }),
                      ),
                    ],
                  ),
                ),
              ),
            ],
          ),
          // Floating Action Buttons for Add to Cart and Buy Now
          Positioned(
            bottom: 20,
            left: 20,
            right: 20,
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                // Add to Cart Button
                FloatingActionButton.extended(
                  onPressed: () {
                    // Add to cart logic goes here
                  },
                  label: Text("Tambahkan ke Keranjang"),
                  icon: Icon(Icons.shopping_cart),
                  backgroundColor: Colors.blue,
                ),
                // Buy Now Button
                FloatingActionButton.extended(
                  onPressed: () {
                    // Buy now logic goes here
                  },
                  label: Text("Beli Sekarang"),
                  icon: Icon(Icons.payment),
                  backgroundColor: Colors.green,
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
