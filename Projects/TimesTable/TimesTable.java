public class TimesTable {
    private int width;//九九表の幅(→方向の数)
    private int height;//九九表の高さ(↓方向の数)
    private int[][] array;//九九表(コンストラクタにて配列の要素数および内容を初期化します)
    private TimesTable(){
        //外部から呼び出せないようにする。
    }
    public TimesTable(int width, int height) {
        //引数で渡される値を設定
        this.width = width;
        this.height = height;

        //配列の初期化
        //生成した配列の値には、(heightのindex + 1) × (widthのindex + 1) を代入
        //new TimesTable(4, 3)で初期化を行った場合、以下の配列リテラルで表される配列データが生成されます。
        //{
        //    {1, 2, 3, 4},
        //    {2, 4, 6, 8},
        //    {3, 6, 9, 12}
        //}
        array = new int[height][width];
        for(int h = 0; h < height; h++)
        {
            for(int w = 0; w < width; w++)
            {
                //array[i][j]に値を代入
                array[h][w] = (h + 1) * (w + 1);
            }
        }
    }
    public static void main(String[] args) {
        //動作確認コードをmainメソッドに書きましょう
        //今回の課題1では、TimesTableクラスの動作確認に外部のクラスを使用しません。 TimesTableクラスにエントリポイントとなるmainメソッドを用意し、そちらで動作確認を行いましょう。
        //自クラスのオブジェクト生成は、TimesTable tt1 = new TimesTable(4, 3);のようなコードをTimesTableクラス中にかけます。これで、作成中クラスの中で自クラスの動作確認が行えます。
        //動作確認のためのコードは、どこまで詳細に確認するコードを書くか悩ましいところかと思います。
        //こちらは、提出されたJavaファイルのmainメソッドでどんな動作確認をしたかもチェックしていますので、動作確認が終わったからと言って消してしまわず、コードコメントアウトや説明コメントなどを用いてコードを残すようにしておいてください。（※ただ何も考えずにたくさんコードを書けばよいわけではありません。どのように動かせば不具合の発見につながるかなどをよく考えてコードを書くようにしましょう。）
        TimesTable case1 = new TimesTable(4, 3);
        System.out.println("4*3の場合");
        case1.print();

        TimesTable case2 = new TimesTable(3, 4);
        System.out.println("3*4の場合");
        case2.print();

        TimesTable case3 = new TimesTable(0, 0);
        System.out.println("0*0の場合");
        case3.print();

        TimesTable case4 = new TimesTable(1, 1);
        System.out.println("1*1の場合");
        case4.print();

        TimesTable case5 = new TimesTable(9, 9);
        System.out.println("9*9の場合");
        case5.print();
    }

    public int getWidth() {
        return width;
    }

    public int getHeight() {
        return height;
    }

    public int[][] getArray() {
        return array;
    }

    public void print() {
        for(int h = 0; h < height; h++)
        {
            for(int w = 0; w < width; w++)
            {
                //array[i][j]の値を順に表示
                //4 x 3の場合
                //|1|2|3|4|
                //|2|4|6|8|
                //|3|6|9|12|

                System.out.print("|" + array[h][w]);
            }
            System.out.println("|");
        }
        System.out.println();
    }
}
