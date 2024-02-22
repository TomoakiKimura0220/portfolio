public class TimesTable {
    private int width;
    private int height;
    private int[][] array;

    //private TimesTable() {}

    public TimesTable(int width, int height) {
        this.width = width;
        this.height = height;

        this.array = new int[height][width];

        for (int h = 0; h < height; h++) {
            for (int w = 0; w < width; w++) {
                this.array[h][w] = (h + 1) * (w + 1);
            }
        }
        // this.arrayの中身はすべて設定されている
    }

    public int getHeight() {
        return height;
    }

    public int getWidth() {
        return width;
    }

    public int[][] getArray() {
        return array;
    }

    public void print() {
        for (int h = 0; h < this.height; h++) {
            System.out.print("|");
            for (int w = 0; w < this.width; w++) {
                System.out.print(this.array[h][w] + "|");
            }
            System.out.println();
        }
    }

    public static void main(String[] args) {

        // 以下動作確認用のコード
        System.out.println("4 x 3");
        new TimesTable(4, 3).print();

        System.out.println("3 x 4");
        new TimesTable(3, 4).print();

        System.out.println("0 x 0");
        new TimesTable(0, 0).print();

        System.out.println("1 x 1");
        new TimesTable(1, 1).print();

        System.out.println("9 x 9");
        new TimesTable(9, 9).print();

        //System.out.println("90 x 90");
        //new TimesTable(90, 90).print();

    }
}